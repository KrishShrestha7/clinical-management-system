<?php

namespace App\Services;

use App\Models\Patient;
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
