<?php

namespace App\Policies;

use App\Models\Order;
use App\Models\User;

class OrderPolicy
{
    /**
     * Determine whether the user can view their order list.
     */
    public function viewAny(User $user): bool
    {
        return $user->isPatient()
            && $user->patient !== null;
    }

    /**
     * Determine whether the user can view the order.
     */
    public function view(User $user, Order $order): bool
    {
        return $user->isPatient()
            && $user->patient !== null
            && $order->patient_id === $user->patient->id;
    }
}
