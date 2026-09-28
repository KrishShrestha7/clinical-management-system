<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RescheduleAppointmentRequest;
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
     * Display all appointments.
     */
    public function index(): View
    {
        $this->authorize('viewAny', Appointment::class);

        $appointments = Appointment::query()
            ->with([
                'patient',
                'doctor.user',
                'creator',
            ])
            ->latest('scheduled_at')
            ->paginate(20);

        return view(
            'admin.appointments.index',
            compact('appointments')
        );
    }

    /**
     * Display one appointment.
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
            'admin.appointments.show',
            compact('appointment')
        );
    }

    /**
     * Confirm a pending appointment.
     */
    public function confirm(
        Appointment $appointment
    ): RedirectResponse {
        $this->authorize('confirm', $appointment);

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
        $this->authorize('cancel', $appointment);

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

    /**
     * Reschedule a pending or confirmed appointment.
     */
    public function reschedule(
        RescheduleAppointmentRequest $request,
        Appointment $appointment
    ): RedirectResponse {
        $this->authorize('reschedule', $appointment);

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
