<?php

namespace App\Services;

use App\Enums\PaymentStatus;
use App\Models\Order;
use App\Models\Patient;
use App\Models\Payment;
use DomainException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Create a payment attempt for an order.
     */
    public function createPaymentAttempt(
        Patient $patient,
        Order $order,
        string $paymentMethod,
        ?string $provider = null
    ): Payment {
        return DB::transaction(function () use (
            $patient,
            $order,
            $paymentMethod,
            $provider
        ) {
            $lockedOrder = Order::query()
                ->whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->patient_id !== $patient->id) {
                throw new DomainException(
                    'You are not authorized to pay for this order.'
                );
            }

            if ($lockedOrder->status !== 'pending') {
                throw new DomainException(
                    'This order is not available for payment.'
                );
            }

            $successfulPaymentExists = $lockedOrder
                ->payments()
                ->where(
                    'status',
                    PaymentStatus::SUCCESSFUL->value
                )
                ->exists();

            if ($successfulPaymentExists) {
                throw new DomainException(
                    'This order has already been paid.'
                );
            }

            $pendingPaymentExists = $lockedOrder
                ->payments()
                ->where(
                    'status',
                    PaymentStatus::PENDING->value
                )
                ->exists();

            if ($pendingPaymentExists) {
                throw new DomainException(
                    'A payment for this order is already in progress.'
                );
            }

            if ((float) $lockedOrder->total_amount <= 0) {
                throw new DomainException(
                    'The order amount must be greater than zero.'
                );
            }

            return $lockedOrder->payments()->create([
                'payment_method' => $paymentMethod,
                'amount' => $lockedOrder->total_amount,
                'status' => PaymentStatus::PENDING->value,
                'transaction_reference' =>
                    $this->generateTransactionReference(),
                'provider' => $provider,
            ]);
        });
    }

    /**
     * Generate a unique payment transaction reference.
     */
    private function generateTransactionReference(): string
    {
        return 'PAY-' . Str::upper(
            (string) Str::ulid()
        );
    }
}
