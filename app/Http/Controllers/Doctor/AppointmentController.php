<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AppointmentService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class AppointmentController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(
        AppointmentService $appointmentService
    ) {
        $this->appointmentService = $appointmentService;
    }

    /**
     * Display appointments assigned to the logged-in doctor.
     */
    public function index(): View
    {
        $doctor = auth()->user()->staff;

        $appointments = $this->appointmentService
            ->getDoctorAppointments($doctor);

        return view(
            'doctor.appointments.index',
            compact('appointments')
        );
    }

    /**
     * Display one assigned appointment.
     */
    public function show(
        Appointment $appointment
    ): View {
        $doctor = auth()->user()->staff;

        if (
            !$doctor ||
            $appointment->doctor_id !== $doctor->id
        ) {
            abort(403);
        }

        $appointment->load([
            'patient',
            'doctor.user',
            'creator',
        ]);

        return view(
            'doctor.appointments.show',
            compact('appointment')
        );
    }

    /**
     * Mark a confirmed appointment as completed.
     */
    public function complete(
        Appointment $appointment
    ): RedirectResponse {
        try {
            $doctor = auth()->user()->staff;

            if (
                !$doctor ||
                $appointment->doctor_id !== $doctor->id
            ) {
                abort(403);
            }

            $this->appointmentService->complete(
                $appointment
            );

            return back()->with(
                'success',
                'Appointment marked as completed.'
            );

        } catch (DomainException $exception) {

            return back()->with(
                'error',
                $exception->getMessage()
            );

        } catch (Throwable $exception) {

            report($exception);

            return back()->with(
                'error',
                'Appointment could not be completed.'
            );
        }
    }

    public function patient(
        Appointment $appointment
    ): View {
        $doctor = auth()->user()->staff;

        if (
            !$doctor ||
            $appointment->doctor_id !== $doctor->id
        ) {
            abort(403);
        }

        $appointment->load('patient');

        return view(
            'doctor.patients.show',
            [
                'patient' => $appointment->patient,
                'appointment' => $appointment,
            ]
        );
    }
}
