<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePrescriptionRequest;
use App\Models\Medicine;
use App\Services\PrescriptionService;
use DomainException;
use Illuminate\Http\RedirectResponse;
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
}
