<?php

namespace App\Services;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class PatientService
{
    /**
     * Get paginated patients.
     */
    public function getPaginated(int $perPage = 10): LengthAwarePaginator
    {
        return Patient::latest()->paginate($perPage);
    }

        /**
     * Create a patient profile for the given user.
     */
    public function createProfile(User $user, array $data): Patient
    {
        return $user->patient()->create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $data['phone'],
            'date_of_birth' => $data['date_of_birth'],
            'gender' => $data['gender'],
            'blood_group' => $data['blood_group'] ?? null,
            'address' => $data['address'],
            'emergency_contact_name' => $data['emergency_contact_name'],
            'emergency_contact_phone' => $data['emergency_contact_phone'],
        ]);
    }

        /**
     * Update the authenticated user's patient profile.
     */
    public function updateProfile(
        Patient $patient,
        array $data
    ): Patient {
        $patient->update($data);

        return $patient->fresh();
    }
    /**
     * Create a new patient.
     */
    public function create(array $data): Patient
    {
        return Patient::create($data);
    }

    /**
     * Update an existing patient.
     */
    public function update(Patient $patient, array $data): Patient
    {
        $patient->update($data);

        return $patient->fresh();
    }

    /**
     * Delete a patient.
     */
    public function delete(Patient $patient): bool
    {
        return $patient->delete();
    }
}
