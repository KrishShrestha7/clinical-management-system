<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use App\Services\PrescriptionService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class PrescriptionController extends Controller
{
    protected PrescriptionService $prescriptionService;

    public function __construct(
        PrescriptionService $prescriptionService
    ) {
        $this->prescriptionService = $prescriptionService;
    }

    public function index(): View
    {
        $this->authorize('viewAny', Prescription::class);

        $prescriptions = Prescription::query()
            ->with([
                'patient',
                'medicine',
                'reviewer',
            ])
            ->latest()
            ->paginate(10);

        return view(
            'admin.prescriptions.index',
            compact('prescriptions')
        );
    }

    public function approve(
        Request $request,
        Prescription $prescription
    ): RedirectResponse {
        $this->authorize('approve', $prescription);

        try {
            $this->prescriptionService->approve(
                $prescription,
                $request->user()
            );

            return back()->with(
                'success',
                'Prescription approved successfully.'
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
                'Prescription could not be approved.'
            );
        }
    }

    public function reject(
        Request $request,
        Prescription $prescription
    ): RedirectResponse {
        $this->authorize('reject', $prescription);

        $validated = $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        try {
            $this->prescriptionService->reject(
                $prescription,
                $request->user(),
                $validated['rejection_reason']
            );

            return back()->with(
                'success',
                'Prescription rejected successfully.'
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
                'Prescription could not be rejected.'
            );
        }
    }
}
