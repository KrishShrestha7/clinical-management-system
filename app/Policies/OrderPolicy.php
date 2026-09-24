<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view the order list.
     */
    public function viewAny(User $user): bool
    {
        return $user->isAdmin()
            || $user->isReceptionist()
            || (
                $user->isPatient()
                && $user->patient !== null
            );
    }

    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        // Admin can view any order.
        if ($user->isAdmin()) {
            return true;
        }

        // Receptionist can view any order.
        if ($user->isReceptionist()) {
            return true;
        }

        // Patient can only view their own order.
        return $user->isPatient()
            && $user->patient !== null
            && $order->patient_id === $user->patient->id;
    }

    /**
     * Determine whether the user may initiate payment for the order.
     */
    public function pay(User $user, Order $order): bool
    {
        return $user->isPatient()
            && $user->patient !== null
            && $order->patient_id === $user->patient->id;
    }
}
