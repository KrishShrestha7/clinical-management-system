<?php

namespace App\Services;

use App\Models\Medicine;
use DomainException;

class CartService
{
    private const SESSION_KEY = 'medicine_cart';

    /**
     * Get all items currently stored in the cart.
     */
    public function getItems(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    /**
     * Add a medicine to the cart.
     */
    public function add(Medicine $medicine, int $quantity): void
    {
        if (!$medicine->isAvailable()) {
            throw new DomainException(
                'This medicine is currently unavailable.'
            );
        }

        $cart = $this->getItems();

        $medicineId = $medicine->id;

        $currentQuantity = $cart[$medicineId]['quantity'] ?? 0;

        $newQuantity = $currentQuantity + $quantity;

        if ($newQuantity > $medicine->stock_quantity) {
            throw new DomainException(
                'The requested quantity exceeds the available stock.'
            );
        }

        $cart[$medicineId] = [
            'medicine_id' => $medicine->id,
            'name' => $medicine->name,
            'price' => $medicine->price,
            'quantity' => $newQuantity,
        ];

        session()->put(self::SESSION_KEY, $cart);
    }

    /**
     * Remove a medicine from the cart.
     */
    public function remove(int $medicineId): void
    {
        $cart = $this->getItems();

        unset($cart[$medicineId]);

        session()->put(self::SESSION_KEY, $cart);
    }

    /**
     * Clear the entire cart.
     */
    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * Calculate the cart total.
     */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getItems() as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }
}
