<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Medicine;
use App\Models\Patient;
use DomainException;

class ApiCartService
{
    /**
     * Get or create the patient's API cart.
     */
    public function getCart(Patient $patient): ?Cart
    {
        return $patient->cart()
            ->with('items.medicine')
            ->first();
    }

    /**
     * Add a medicine to the patient's API cart.
     */
    public function add(
        Patient $patient,
        Medicine $medicine,
        int $quantity
    ): Cart {
        if ($quantity < 1) {
            throw new DomainException(
                'Quantity must be at least 1.'
            );
        }

        if (!$medicine->isAvailable()) {
            throw new DomainException(
                'This medicine is currently unavailable.'
            );
        }

        $cart = $patient->cart()->firstOrCreate([]);

        $cartItem = $cart->items()
            ->where('medicine_id', $medicine->id)
            ->first();

        $currentQuantity = $cartItem?->quantity ?? 0;

        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $medicine->stock_quantity) {
            throw new DomainException(
                "Only {$medicine->stock_quantity} units of {$medicine->name} are currently available."
            );
        }

        if ($cartItem) {
            $cartItem->update([
                'quantity' => $newQuantity,
            ]);
        } else {
            $cart->items()->create([
                'medicine_id' => $medicine->id,
                'quantity' => $quantity,
            ]);
        }

        return $cart->fresh([
            'items.medicine',
        ]);
    }

    /**
     * Remove a medicine from the patient's API cart.
     */
    public function remove(
        Patient $patient,
        Medicine $medicine
    ): bool {
        $cart = $patient->cart;

        if (!$cart) {
            return false;
        }

        $deleted = $cart->items()
            ->where('medicine_id', $medicine->id)
            ->delete();

        return $deleted > 0;
    }

    /**
     * Clear all items from the patient's API cart.
     */
    public function clear(Patient $patient): void
    {
        $patient->cart?->items()->delete();
    }
}
