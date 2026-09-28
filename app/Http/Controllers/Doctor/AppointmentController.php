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
        $this->authorize('viewAny', Appointment::class);

        $doctor = auth()->user()->staff;

        if (!$doctor) {
            abort(403);
        }

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
        $this->authorize('view', $appointment);

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
     * Display the patient associated with an appointment.
     */
    public function patient(
        Appointment $appointment
    ): View {
        $this->authorize('view', $appointment);

        $appointment->load('patient');

        return view(
            'doctor.patients.show',
            [
                'patient' => $appointment->patient,
                'appointment' => $appointment,
            ]
        );
    }

    /**
     * Display the patient's clinical history.
     */
    public function history(
        Appointment $appointment
    ): View {
        $this->authorize('view', $appointment);

        $doctor = auth()->user()->staff;

        if (!$doctor) {
            abort(403);
        }

        $history = $this->appointmentService->getPatientHistory(
            $appointment->patient,
            $doctor
        );

        return view(
            'doctor.patients.history',
            [
                'patient' => $appointment->patient,
                'appointment' => $appointment,
                'appointments' => $history['appointments'],
                'prescriptions' => $history['prescriptions'],
                'orders' => $history['orders'],
            ]
        );
    }

    /**
     * Mark a confirmed appointment as completed.
     */
    public function complete(
        Appointment $appointment
    ): RedirectResponse {
        $this->authorize('complete', $appointment);

        try {
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
}
