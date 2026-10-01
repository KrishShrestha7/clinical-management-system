<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\Order;
use App\Models\Patient;
use App\Enums\OrderStatus;
use App\Enums\PrescriptionStatus;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OrderService
{

    /**
     * Get paginated orders for the given patient.
     */
    public function getPatientOrders(
        Patient $patient,
        int $perPage = 10
    ): LengthAwarePaginator {
        return $patient->orders()
            ->withCount('items')
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Get an order with its items and medicines.
     */
    public function getOrderDetails(Order $order): Order
    {
        return $order->load([
            'patient',
            'items.medicine',
            'payments',
        ]);
    }
    /**
     * Create an order from the patient's cart.
     */
    public function checkout(
        Patient $patient,
        array $cartItems
    ): Order {
        if (empty($cartItems)) {
            throw new DomainException(
                'Your cart is empty.'
            );
        }

        return DB::transaction(function () use ($patient, $cartItems) {

            $order = $patient->orders()->create([
                'order_number' => $this->generateOrderNumber(),
                'status' => OrderStatus::PENDING->value,
                'subtotal_amount' => 0,
                'vat_rate' => 0,
                'vat_amount' => 0,
                'total_amount' => 0,
            ]);

            $subtotalAmount = 0;

            foreach ($cartItems as $item) {

                $medicine = Medicine::query()
                    ->whereKey($item['medicine_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$medicine || !$medicine->is_active) {
                    throw new DomainException(
                        'One of the medicines in your cart is no longer available.'
                    );
                }

                $quantity = (int) $item['quantity'];

                if ($quantity < 1) {
                    throw new DomainException(
                        'Medicine quantity must be at least 1.'
                    );
                }

                if ($quantity > $medicine->stock_quantity) {
                    throw new DomainException(
                        "Only {$medicine->stock_quantity} units of {$medicine->name} are currently available."
                    );
                }

                if ($medicine->requires_prescription) {
                    $hasApprovedPrescription = $patient->prescriptions()
                        ->where('medicine_id', $medicine->id)
                        ->where(
                            'status',
                            PrescriptionStatus::APPROVED->value
                        )
                        ->exists();

                    if (!$hasApprovedPrescription) {
                        throw new DomainException(
                            "{$medicine->name} requires an approved prescription before checkout."
                        );
                    }
                }

                $unitPrice = (float) $medicine->price;

                $lineTotal = round(
                    $unitPrice * $quantity,
                    2
                );

                $order->items()->create([
                    'medicine_id' => $medicine->id,
                    'medicine_name' => $medicine->name,
                    'quantity' => $quantity,
                    'unit_price' => $medicine->price,
                    'line_total' => $lineTotal,
                ]);

                $medicine->decrement(
                    'stock_quantity',
                    $quantity
                );

                $subtotalAmount += $lineTotal;
            }

            $subtotalAmount = round(
                $subtotalAmount,
                2
            );

            $vatRate = (float) config(
                'billing.vat_rate',
                13
            );

            $vatAmount = round(
                $subtotalAmount * ($vatRate / 100),
                2
            );

            $totalAmount = round(
                $subtotalAmount + $vatAmount,
                2
            );

            $order->update([
                'subtotal_amount' => $subtotalAmount,
                'vat_rate' => $vatRate,
                'vat_amount' => $vatAmount,
                'total_amount' => $totalAmount,
            ]);

            return $order->fresh([
                'items',
            ]);
        });
    }

    /**
     * Generate a unique order number.
     */
    private function generateOrderNumber(): string
    {
        $lastOrder = Order::query()
            ->where('order_number', 'like', 'ORD-%')
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;

        if ($lastOrder) {
            $lastNumber = (int) str_replace(
                'ORD-',
                '',
                $lastOrder->order_number
            );

            $nextNumber = $lastNumber + 1;
        }

        return 'ORD-' . str_pad(
            $nextNumber,
            2,
            '0',
            STR_PAD_LEFT
        );
    }
}
