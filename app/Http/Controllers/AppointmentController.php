<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAppointmentRequest;
use App\Models\Appointment;
use App\Services\AppointmentService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class AppointmentController extends Controller
{
    protected AppointmentService $appointmentService;

    public function __construct(AppointmentService $appointmentService)
    {
        $this->appointmentService = $appointmentService;
    }

    public function index(): View
    {
        $this->authorize('viewAny', Appointment::class);

        $patient = auth()->user()->patient;

        $appointments = $this->appointmentService
            ->getPatientAppointments($patient);

        return view(
            'appointments.index',
            compact('appointments')
        );
    }

    public function create(): View
    {
        $this->authorize('create', Appointment::class);

        $doctors = $this->appointmentService->getDoctors();

        return view(
            'appointments.create',
            compact('doctors')
        );
    }

    public function store(
        StoreAppointmentRequest $request
    ): RedirectResponse {
        $this->authorize('create', Appointment::class);

        try {
            $user = $request->user();
            $patient = $user->patient;

            $this->appointmentService->create(
                $patient,
                $request->validated(),
                $user
            );

            return redirect()
                ->route('appointments.index')
                ->with(
                    'success',
                    'Appointment request submitted successfully.'
                );

        } catch (DomainException $exception) {

            return back()
                ->withInput()
                ->withErrors([
                    'appointment' => $exception->getMessage(),
                ]);

        } catch (Throwable $exception) {

            report($exception);

            return back()
                ->withInput()
                ->withErrors([
                    'appointment' => 'Unable to book the appointment.',
                ]);
        }
    }

    public function show(
        Appointment $appointment
    ): View {
        $this->authorize('view', $appointment);

        $appointment->load([
            'doctor.user',
            'creator',
        ]);

        return view(
            'appointments.show',
            compact('appointment')
        );
    }
}
