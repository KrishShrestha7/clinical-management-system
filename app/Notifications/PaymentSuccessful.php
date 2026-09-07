<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentSuccessful extends Notification
{
    use Queueable;

    public function __construct(
        protected Order $order,
        protected Payment $payment
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Payment Successful - ' . $this->order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your payment was completed successfully.')
            ->line('Order Number: ' . $this->order->order_number)
            ->line(
                'Amount Paid: Rs. '
                . number_format((float) $this->payment->amount, 2)
            )
            ->line(
                'Payment Reference: '
                . $this->payment->transaction_reference
            )
            ->line(
                'Paid At: '
                . $this->payment->paid_at?->format('Y-m-d H:i')
            )
            ->action(
                'View Receipt',
                route('orders.receipt', $this->order)
            )
            ->line('Thank you for your payment.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
