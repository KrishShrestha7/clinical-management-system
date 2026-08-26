<?php

namespace App\Policies;

use App\Models\Patient;
use App\Models\User;

class PatientPolicy
{
    /**
     * Determine whether the user can view any patients.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin()
            || $user->isDoctor()
            || $user->isReceptionist();
    }

    /**
     * Determine whether the user can view the patient.
     */
    public function view(User $user, Patient $patient): bool
    {
        return $user->isAdmin()
            || $user->isDoctor()
            || $user->isReceptionist();
    }

    /**
     * Determine whether the user can create patients.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin()
            || $user->isDoctor()
            || $user->isReceptionist();
    }

        /**
     * Determine whether the user can create their own patient profile.
     */
    public function createOwnProfile(User $user): bool
    {
        return $user->isPatient()
            && $user->patient === null;
    }

        /**
     * Determine whether the user can view their own patient profile.
     */
    public function viewOwnProfile(User $user): bool
    {
        return $user->isPatient()
            && $user->patient !== null;
    }

    /**
     * Determine whether the user can update their own patient profile.
     */
    public function updateOwnProfile(User $user): bool
    {
        return $user->isPatient()
            && $user->patient !== null;
    }

    /**
     * Determine whether the user can update the patient.
     */
    public function update(User $user, Patient $patient): bool
    {
        return $user->isAdmin()
            || $user->isDoctor();
    }

    /**
     * Determine whether the user can delete the patient.
     */
    public function delete(User $user, Patient $patient): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can restore the patient.
     */
    public function restore(User $user, Patient $patient): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine whether the user can permanently delete the patient.
     */
    public function forceDelete(User $user, Patient $patient): bool
    {
        return $user->isAdmin();
    }
}
