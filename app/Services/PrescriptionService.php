<?php

namespace App\Services;

use App\Enums\PrescriptionStatus;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use Illuminate\Http\UploadedFile;

class PrescriptionService
{
    public function create(
        Patient $patient,
        Medicine $medicine,
        UploadedFile $file
    ): Prescription {
        $filePath = $file->store(
            'prescriptions',
            'public'
        );

        return Prescription::create([
            'patient_id' => $patient->id,
            'medicine_id' => $medicine->id,
            'file_path' => $filePath,
            'status' => PrescriptionStatus::PENDING->value,
        ]);
    }
}
