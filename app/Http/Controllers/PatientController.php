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

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService
    ) {
        $this->authorizeResource(Patient::class, 'patient');
    }

    /**
     * Display a listing of patients.
     */
    public function index(): View
    {
        $patients = Patient::latest()->paginate(10);

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
    public function store(StorePatientRequest $request): RedirectResponse|PatientResource
    {
        $patient = $this->patientService->create(
            $request->validated()
        );

        if ($request->expectsJson()) {
            return new PatientResource($patient);
        }

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Patient created successfully.');
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
    ): RedirectResponse|PatientResource {

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
    }

    /**
     * Remove the specified patient.
     */
    public function destroy(
        Request $request,
        Patient $patient
    ): RedirectResponse|JsonResponse {

        $this->patientService->delete($patient);

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}
