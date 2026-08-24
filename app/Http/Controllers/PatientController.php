<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use throwable;

class PatientController extends Controller
{

    protected PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;

        $this->authorizeResource(Patient::class, 'patient');
    }

    /**
     * Display a listing of patients.
     */
    public function index(): View
    {
        $patients = $this->patientService->getPaginated();

        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new patient.
     */
    public function create(): View
    {
        return view('patients.create');
    }

    /**
     * Store a newly created patient.
     */
    public function store(
        StorePatientRequest $request
    ): RedirectResponse|PatientResource|JsonResponse {
        try {
            $patient = $this->patientService->create(
                $request->validated()
            );

            if ($request->expectsJson()) {
                return new PatientResource($patient);
            }

            return redirect()
                ->route('patients.show', $patient)
                ->with('success', 'Patient created successfully.');
        } catch (Throwable $exception) {
            report($exception);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Patient could not be created.',
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Patient could not be created. Please try again.');
        }
    }

    /**
     * Display the specified patient.
     */
    public function show(
        Request $request,
        Patient $patient
    ): View|PatientResource {

        if ($request->expectsJson()) {
            return new PatientResource($patient);
        }

        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit(Patient $patient): View
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified patient.
     */
    public function update(
        UpdatePatientRequest $request,
        Patient $patient
    ): RedirectResponse|PatientResource|JsonResponse {
        try {
            $patient = $this->patientService->update(
                $patient,
                $request->validated()
            );

            if ($request->expectsJson()) {
                return new PatientResource($patient);
            }

            return redirect()
                ->route('patients.show', $patient)
                ->with('success', 'Patient updated successfully.');
        } catch (Throwable $exception) {
            report($exception);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Patient could not be updated.',
                ], 500);
            }

            return back()
                ->withInput()
                ->with('error', 'Patient could not be updated. Please try again.');
        }
    }

    /**
     * Remove the specified patient.
     */
    public function destroy(
        Request $request,
        Patient $patient
    ): RedirectResponse|JsonResponse {
        try {
            $this->patientService->delete($patient);

            if ($request->expectsJson()) {
                return response()->json(null, 204);
            }

            return redirect()
                ->route('patients.index')
                ->with('success', 'Patient deleted successfully.');
        } catch (Throwable $exception) {
            report($exception);

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Patient could not be deleted.',
                ], 500);
            }

            return back()
                ->with('error', 'Patient could not be deleted. Please try again.');
        }
    }
}
