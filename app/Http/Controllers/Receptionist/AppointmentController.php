<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Services\AppointmentService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Http\Requests\RescheduleAppointmentRequest;
use App\Http\Requests\StoreReceptionistAppointmentRequest;
use App\Models\Patient;
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
     * Display all appointments.
     */
    public function index(): View
    {
        $appointments = Appointment::query()
            ->with([
                'patient',
                'doctor.user',
            ])
            ->latest('scheduled_at')
            ->paginate(15);

        return view(
            'receptionist.appointments.index',
            compact('appointments')
        );
    }

    /**
     * Display one appointment.
     */
    public function show(
        Appointment $appointment
    ): View {
        $appointment->load([
            'patient',
            'doctor.user',
            'creator',
        ]);

        return view(
            'receptionist.appointments.show',
            compact('appointment')
        );
    }

    /**
     * Confirm a pending appointment.
     */
    public function confirm(
        Appointment $appointment
    ): RedirectResponse {
        try {
            $this->appointmentService->confirm(
                $appointment
            );

            return back()->with(
                'success',
                'Appointment confirmed successfully.'
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
                'Appointment could not be confirmed.'
            );
        }
    }

    /**
     * Cancel a pending or confirmed appointment.
     */
    public function cancel(
        Appointment $appointment
    ): RedirectResponse {
        try {
            $this->appointmentService->cancel(
                $appointment
            );

            return back()->with(
                'success',
                'Appointment cancelled successfully.'
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
                'Appointment could not be cancelled.'
            );
        }
    }

    public function reschedule(
        RescheduleAppointmentRequest $request,
        Appointment $appointment
    ): RedirectResponse {
        try {
            $this->appointmentService->reschedule(
                $appointment,
                $request->validated()['scheduled_at']
            );

            return back()->with(
                'success',
                'Appointment rescheduled successfully.'
            );

        } catch (DomainException $exception) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->getMessage()
                );

        } catch (Throwable $exception) {

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Appointment could not be rescheduled.'
                );
        }
    }

    public function create(): View
    {
        $patients = $this->appointmentService->getPatients();
        $doctors = $this->appointmentService->getDoctors();

        return view(
            'receptionist.appointments.create',
            compact('patients', 'doctors')
        );
    }

    public function store(
        StoreReceptionistAppointmentRequest $request
    ): RedirectResponse {
        try {
            $data = $request->validated();

            $patient = Patient::findOrFail(
                $data['patient_id']
            );

            $this->appointmentService->create(
                $patient,
                $data,
                $request->user()
            );

            return redirect()
                ->route('receptionist.appointments.index')
                ->with(
                    'success',
                    'Appointment created successfully.'
                );

        } catch (DomainException $exception) {

            return back()
                ->withInput()
                ->with(
                    'error',
                    $exception->getMessage()
                );

        } catch (Throwable $exception) {

            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Appointment could not be created.'
                );
        }
    }
}
