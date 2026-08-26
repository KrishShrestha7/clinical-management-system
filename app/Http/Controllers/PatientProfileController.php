<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePatientProfileRequest;
use App\Http\Requests\UpdatePatientProfileRequest;
use App\Models\Patient;
use App\Services\PatientService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Throwable;

class PatientProfileController extends Controller
{
    protected PatientService $patientService;

    public function __construct(PatientService $patientService)
    {
        $this->patientService = $patientService;
    }

    /**
     * Show the form for creating the authenticated patient's profile.
     */
    public function create(): View
    {
        $this->authorize('createOwnProfile', Patient::class);

        return view('patient-profile.create');
    }

    /**
     * Store the authenticated patient's profile.
     */
    public function store(
        StorePatientProfileRequest $request
    ): RedirectResponse {
        $this->authorize('createOwnProfile', Patient::class);

        try {
            $this->patientService->createProfile(
                $request->user(),
                $request->validated()
            );

            return redirect()
                ->route('dashboard')
                ->with('success', 'Your patient profile has been completed successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Your patient profile could not be created. Please try again.'
                );
        }
    }

        /**
     * Display the authenticated patient's profile.
     */
    public function show(): View|RedirectResponse
    {
        $user = auth()->user();

        if (!$user->patient) {
            return redirect()
                ->route('patient-profile.create');
        }

        $this->authorize('viewOwnProfile', Patient::class);

        return view('patient-profile.show', [
            'patient' => $user->patient,
        ]);
    }

    /**
     * Show the form for editing the authenticated patient's profile.
     */
    public function edit(): View|RedirectResponse
    {
        $user = auth()->user();

        if (!$user->patient) {
            return redirect()
                ->route('patient-profile.create');
        }

        $this->authorize('updateOwnProfile', Patient::class);

        return view('patient-profile.edit', [
            'patient' => $user->patient,
        ]);
    }

    /**
     * Update the authenticated patient's profile.
     */
    public function update(
        UpdatePatientProfileRequest $request
    ): RedirectResponse {
        $user = $request->user();

        if (!$user->patient) {
            return redirect()
                ->route('patient-profile.create');
        }

        $this->authorize('updateOwnProfile', Patient::class);

        try {
            $this->patientService->updateProfile(
                $user->patient,
                $request->validated()
            );

            return redirect()
                ->route('patient-profile.show')
                ->with('success', 'Your patient profile has been updated successfully.');
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->with(
                    'error',
                    'Your patient profile could not be updated. Please try again.'
                );
        }
    }
}
