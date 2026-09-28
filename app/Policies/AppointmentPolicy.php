<?php

namespace App\Policies;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use App\Models\User;

class AppointmentPolicy
{
    /**
     * Determine whether the user can view any appointments.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin()
            || $user->isReceptionist()
            || $user->isDoctor()
            || (
                $user->isPatient()
                && $user->patient !== null
            );
    }

    /**
     * Determine whether the user can view the appointment.
     */
    public function view(User $user, Appointment $appointment): bool
    {
        // Admin can view any appointment.
        if ($user->isAdmin()) {
            return true;
        }

        // Receptionist can view any appointment.
        if ($user->isReceptionist()) {
            return true;
        }

        // Doctor can only view appointments assigned to them.
        if ($user->isDoctor()) {
            return $user->staff !== null
                && $appointment->doctor_id === $user->staff->id;
        }

        // Patient can only view their own appointments.
        return $user->isPatient()
            && $user->patient !== null
            && $appointment->patient_id === $user->patient->id;
    }

    /**
     * Determine whether the user can create an appointment.
     */
    public function create(User $user): bool
    {
        return $user->isAdmin()
            || $user->isReceptionist()
            || (
                $user->isPatient()
                && $user->patient !== null
            );
    }

    /**
     * Determine whether the user can confirm an appointment.
     */
    public function confirm(
        User $user,
        Appointment $appointment
    ): bool {
        return $user->isAdmin()
            || $user->isReceptionist();
    }

    /**
     * Determine whether the user can cancel an appointment.
     */
    public function cancel(
        User $user,
        Appointment $appointment
    ): bool {
        return $user->isAdmin()
            || $user->isReceptionist();
    }

    /**
     * Determine whether the user can reschedule an appointment.
     */
    public function reschedule(
        User $user,
        Appointment $appointment
    ): bool {
        return $user->isAdmin()
            || $user->isReceptionist();
    }

    /**
     * Determine whether the user can complete an appointment.
     */
    public function complete(
        User $user,
        Appointment $appointment
    ): bool {
        // Admin can manage all appointments.
        if ($user->isAdmin()) {
            return true;
        }

        // Only the assigned doctor can complete an appointment.
        return $user->isDoctor()
            && $user->staff !== null
            && $appointment->doctor_id === $user->staff->id
            && $appointment->status === AppointmentStatus::CONFIRMED;
    }
}
