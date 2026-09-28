<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrescriptionRequest;
use App\Models\Medicine;
use App\Models\Prescription;
use App\Services\PrescriptionService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Throwable;

class PrescriptionController extends Controller
{
    protected PrescriptionService $prescriptionService;

    public function __construct(
        PrescriptionService $prescriptionService
    ) {
        $this->prescriptionService = $prescriptionService;
    }

    public function store(
        StorePrescriptionRequest $request,
        Medicine $medicine
    ): RedirectResponse {
        $this->authorize('create', Prescription::class);

        try {
            if (!$medicine->requires_prescription) {
                throw new DomainException(
                    'This medicine does not require a prescription.'
                );
            }

            $patient = $request->user()->patient;

            $this->prescriptionService->create(
                $patient,
                $medicine,
                $request->file('prescription_file')
            );

            return back()->with(
                'success',
                'Prescription uploaded successfully and is waiting for admin review.'
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
                'Prescription could not be uploaded.'
            );
        }
    }

    public function file(
        Prescription $prescription
    ): \Symfony\Component\HttpFoundation\BinaryFileResponse {
        $this->authorize('view', $prescription);

        $filePath = storage_path(
            'app/' . $prescription->file_path
        );

        if (!is_file($filePath)) {
            abort(404, 'Prescription file not found.');
        }

        return response()->file(
            $filePath,
            [
                'Content-Disposition' =>
                    'inline; filename="' .
                    basename($prescription->file_path) .
                    '"',
            ]
        );
    }
}
