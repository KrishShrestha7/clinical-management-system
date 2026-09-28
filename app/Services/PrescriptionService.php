<?php

namespace App\Services;

use App\Enums\PrescriptionStatus;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\Prescription;
use App\Models\User;
use DomainException;
use Illuminate\Http\UploadedFile;

class PrescriptionService
{
    public function create(
        Patient $patient,
        Medicine $medicine,
        UploadedFile $file
    ): Prescription {
        $filePath = $file->store(
            'prescriptions'
        );

        return Prescription::create([
            'patient_id' => $patient->id,
            'medicine_id' => $medicine->id,
            'file_path' => $filePath,
            'status' => PrescriptionStatus::PENDING->value,
        ]);
    }

    public function approve(
        Prescription $prescription,
        User $reviewer
    ): Prescription {
        if (
            $prescription->status !== PrescriptionStatus::PENDING
        ) {
            throw new DomainException(
                'Only pending prescriptions can be approved.'
            );
        }

        $prescription->update([
            'status' => PrescriptionStatus::APPROVED->value,
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
            'rejection_reason' => null,
        ]);

        return $prescription->fresh([
            'patient',
            'medicine',
            'reviewer',
        ]);
    }

    public function reject(
        Prescription $prescription,
        User $reviewer,
        string $rejectionReason
    ): Prescription {
        if (
            $prescription->status !== PrescriptionStatus::PENDING
        ) {
            throw new DomainException(
                'Only pending prescriptions can be rejected.'
            );
        }

        $prescription->update([
            'status' => PrescriptionStatus::REJECTED->value,
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
            'rejection_reason' => $rejectionReason,
        ]);

        return $prescription->fresh([
            'patient',
            'medicine',
            'reviewer',
        ]);
    }
}
