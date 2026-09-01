<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientProfileRequest;
use App\Http\Requests\UpdatePatientProfileRequest;
use App\Http\Resources\PatientResource;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PatientProfileController extends Controller
{
    protected PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * Display the authenticated patient's profile.
     */
    public function show(Request $request): JsonResponse
    {
        $patient = $request->user()->patient;

        if (!$patient) {
            return response()->json([
                'message' => 'Patient profile has not been completed yet.',
            ], 404);
        }

        $this->authorize('viewOwnProfile', Patient::class);

        return response()->json([
            'message' => 'Patient profile retrieved successfully.',
            'data' => new PatientResource($patient),
        ]);
    }

    /**
     * Create the authenticated patient's clinical profile.
     */
    public function store(
        StorePatientProfileRequest $request
    ): JsonResponse {
        $this->authorize('createOwnProfile', Patient::class);

        try {
            $patient = $this->patientService->createProfile(
                $request->user(),
                $request->validated()
            );

            return response()->json([
                'message' => 'Patient profile created successfully.',
                'data' => new PatientResource($patient),
            ], 201);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Patient profile could not be created.',
            ], 500);
        }
    }

    /**
     * Update the authenticated patient's clinical profile.
     */
    public function update(
        UpdatePatientProfileRequest $request
    ): JsonResponse {
        $patient = $request->user()->patient;

        $this->authorize('updateOwnProfile', Patient::class);

        try {
            $patient = $this->patientService->updateProfile(
                $patient,
                $request->validated()
            );

            return response()->json([
                'message' => 'Patient profile updated successfully.',
                'data' => new PatientResource($patient),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'message' => 'Patient profile could not be updated.',
            ], 500);
        }
    }
}
