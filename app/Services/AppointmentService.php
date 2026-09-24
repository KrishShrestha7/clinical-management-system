<?php

namespace App\Services;

use App\Enums\AppointmentStatus;
use App\Enums\UserRole;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Staff;
use App\Models\User;
use Carbon\Carbon;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class AppointmentService
{
    public function create(
        Patient $patient,
        array $data,
        User $creator
    ): Appointment {
        return DB::transaction(function () use ($patient, $data, $creator) {

            $scheduledAt = Carbon::parse($data['scheduled_at']);

            if (! $scheduledAt->isFuture()) {
                throw new DomainException(
                    'The appointment must be scheduled for a future date and time.'
                );
            }

            $doctor = Staff::query()
                ->with('user')
                ->lockForUpdate()
                ->findOrFail($data['doctor_id']);

            if (
                ! $doctor->user ||
                $doctor->user->role !== UserRole::DOCTOR
            ) {
                throw new DomainException(
                    'The selected staff member is not a doctor.'
                );
            }

            $activeStatuses = [
                AppointmentStatus::PENDING->value,
                AppointmentStatus::CONFIRMED->value,
            ];

            $doctorHasConflict = Appointment::query()
                ->where('doctor_id', $doctor->id)
                ->where('scheduled_at', $scheduledAt)
                ->whereIn('status', $activeStatuses)
                ->exists();

            if ($doctorHasConflict) {
                throw new DomainException(
                    'The selected doctor already has an appointment at this time.'
                );
            }

            $patientHasConflict = Appointment::query()
                ->where('patient_id', $patient->id)
                ->where('scheduled_at', $scheduledAt)
                ->whereIn('status', $activeStatuses)
                ->exists();

            if ($patientHasConflict) {
                throw new DomainException(
                    'You already have an appointment scheduled at this time.'
                );
            }

            return Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'scheduled_at' => $scheduledAt,
                'reason' => $data['reason'],
                'status' => AppointmentStatus::PENDING,
                'notes' => $data['notes'] ?? null,
                'created_by' => $creator->id,
            ]);
        });
    }

    public function getPatientAppointments(
        Patient $patient,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Appointment::query()
            ->where('patient_id', $patient->id)
            ->with('doctor.user')
            ->latest('scheduled_at')
            ->paginate($perPage);
    }

    public function getDoctors(): Collection
    {
        return Staff::query()
            ->whereHas('user', function ($query) {
                $query->where('role', UserRole::DOCTOR->value);
            })
            ->with('user')
            ->orderBy('employee_id')
            ->get();
    }

    public function confirm(Appointment $appointment): Appointment
    {
        if ($appointment->status !== AppointmentStatus::PENDING) {
            throw new DomainException(
                'Only pending appointments can be confirmed.'
            );
        }

        $appointment->update([
            'status' => AppointmentStatus::CONFIRMED,
        ]);

        return $appointment->fresh();
    }


    public function complete(Appointment $appointment): Appointment
    {
        if ($appointment->status !== AppointmentStatus::CONFIRMED) {
            throw new DomainException(
                'Only confirmed appointments can be completed.'
            );
        }

        $appointment->update([
            'status' => AppointmentStatus::COMPLETED,
        ]);

        return $appointment->fresh();
    }


    public function cancel(Appointment $appointment): Appointment
    {
        if (
            ! in_array(
                $appointment->status,
                [
                    AppointmentStatus::PENDING,
                    AppointmentStatus::CONFIRMED,
                ],
                true
            )
        ) {
            throw new DomainException(
                'Only pending or confirmed appointments can be cancelled.'
            );
        }

        $appointment->update([
            'status' => AppointmentStatus::CANCELLED,
        ]);

        return $appointment->fresh();
    }

    public function reschedule(
        Appointment $appointment,
        string $scheduledAt
    ): Appointment {
        return DB::transaction(function () use (
            $appointment,
            $scheduledAt
        ) {
            if (
                ! in_array(
                    $appointment->status,
                    [
                        AppointmentStatus::PENDING,
                        AppointmentStatus::CONFIRMED,
                    ],
                    true
                )
            ) {
                throw new DomainException(
                    'Only pending or confirmed appointments can be rescheduled.'
                );
            }

            $newScheduledAt = Carbon::parse($scheduledAt);

            if (! $newScheduledAt->isFuture()) {
                throw new DomainException(
                    'The new appointment time must be in the future.'
                );
            }

            $doctorHasConflict = Appointment::query()
                ->where('doctor_id', $appointment->doctor_id)
                ->where('id', '!=', $appointment->id)
                ->where(
                    'scheduled_at',
                    $newScheduledAt
                )
                ->whereIn('status', [
                    AppointmentStatus::PENDING->value,
                    AppointmentStatus::CONFIRMED->value,
                ])
                ->exists();

            if ($doctorHasConflict) {
                throw new DomainException(
                    'The selected doctor already has an appointment at this time.'
                );
            }

            $patientHasConflict = Appointment::query()
                ->where('patient_id', $appointment->patient_id)
                ->where('id', '!=', $appointment->id)
                ->where(
                    'scheduled_at',
                    $newScheduledAt
                )
                ->whereIn('status', [
                    AppointmentStatus::PENDING->value,
                    AppointmentStatus::CONFIRMED->value,
                ])
                ->exists();

            if ($patientHasConflict) {
                throw new DomainException(
                    'The patient already has an appointment at this time.'
                );
            }

            $appointment->update([
                'scheduled_at' => $newScheduledAt,
            ]);

            return $appointment->fresh();
        });
    }

    public function getPatients(): Collection
    {
        return Patient::query()
            ->orderBy('name')
            ->get();
    }

    public function getDoctorAppointments(
        Staff $doctor,
        int $perPage = 10
    ): LengthAwarePaginator {
        return Appointment::query()
            ->where('doctor_id', $doctor->id)
            ->with([
                'patient',
                'doctor.user',
            ])
            ->latest('scheduled_at')
            ->paginate($perPage);
    }

    public function getPatientHistory(
        Patient $patient,
        Staff $doctor
    ): array {
        $hasAppointmentWithDoctor = Appointment::query()
            ->where('patient_id', $patient->id)
            ->where('doctor_id', $doctor->id)
            ->exists();

        if (!$hasAppointmentWithDoctor) {
            throw new DomainException(
                'You are not authorized to view this patient history.'
            );
        }

        $appointments = Appointment::query()
            ->where('patient_id', $patient->id)
            ->with('doctor.user')
            ->latest('scheduled_at')
            ->get();

        $prescriptions = $patient->prescriptions()
            ->with('medicine')
            ->latest()
            ->get();

        $orders = $patient->orders()
            ->with('items')
            ->latest()
            ->get();

        return [
            'appointments' => $appointments,
            'prescriptions' => $prescriptions,
            'orders' => $orders,
        ];
    }
}
