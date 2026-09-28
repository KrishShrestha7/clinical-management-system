<?php

namespace App\Policies;

use App\Models\Prescription;
use App\Models\User;

class PrescriptionPolicy
{
    /**
     * Determine whether the user can view any prescriptions.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin()
            || (
                $user->isPatient()
                && $user->patient !== null
            );
    }

    /**
     * Determine whether the user can view the prescription.
     */
    public function view(
        User $user,
        Prescription $prescription
    ): bool {
        // Admin can view any prescription.
        if ($user->isAdmin()) {
            return true;
        }

        // Patient can only view their own prescription.
        return $user->isPatient()
            && $user->patient !== null
            && $prescription->patient_id === $user->patient->id;
    }

    /**
     * Determine whether the user can create a prescription.
     */
    public function create(User $user): bool
    {
        return $user->isPatient()
            && $user->patient !== null;
    }

    /**
     * Determine whether the user can approve a prescription.
     */
    public function approve(
        User $user,
        Prescription $prescription
    ): bool {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can reject a prescription.
     */
    public function reject(
        User $user,
        Prescription $prescription
    ): bool {
        return $user->isAdmin();
    }
}
