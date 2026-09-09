<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PrescriptionStatus;
use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Throwable;

class PrescriptionController extends Controller
{
    public function index(): View
    {
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
        try {
            $prescription->update([
                'status' => PrescriptionStatus::APPROVED->value,
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
                'rejection_reason' => null,
            ]);

            return back()->with(
                'success',
                'Prescription approved successfully.'
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
        $request->validate([
            'rejection_reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        try {
            $prescription->update([
                'status' => PrescriptionStatus::REJECTED->value,
                'reviewed_by' => $request->user()->id,
                'reviewed_at' => now(),
                'rejection_reason' => $request->rejection_reason,
            ]);

            return back()->with(
                'success',
                'Prescription rejected successfully.'
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
