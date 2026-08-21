<?php

namespace App\Services;

use App\Models\Patient;

class PatientService
{
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
