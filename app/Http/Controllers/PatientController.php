<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService
    ) {
        $this->authorizeResource(Patient::class, 'patient');
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $patients = $this->patientService->paginate();

        if ($request->expectsJson()) {
            return PatientResource::collection($patients);
        }

        return view('patients.index', compact('patients'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {
        $patient = $this->patientService->create($request->validated());

        if ($request->expectsJson()) {
            return new PatientResource($patient);
        }

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Patient created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Patient $patient)
    {
        if ($request->expectsJson()) {
            return new PatientResource($patient);
        }

        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, Patient $patient)
    {
        $patient = $this->patientService->update($patient, $request->validated());

        if ($request->expectsJson()) {
            return new PatientResource($patient);
        }

        return redirect()
            ->route('patients.show', $patient)
            ->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Patient $patient)
    {
        $this->patientService->delete($patient);

        if ($request->expectsJson()) {
            return response()->json(null, 204);
        }

        return redirect()
            ->route('patients.index')
            ->with('success', 'Patient deleted successfully.');
    }
}
