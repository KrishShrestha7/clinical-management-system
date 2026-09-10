<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrderPlaced extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Order $order
    ) {
    }

    /**
     * Get the notification delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Build the order confirmation email.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $order = $this->order->loadMissing('items');

        $mail = (new MailMessage)
            ->subject('Order Confirmation - ' . $order->order_number)
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your medicine order has been placed successfully.')
            ->line('Order Number: ' . $order->order_number);

        foreach ($order->items as $item) {
            $mail->line(
                $item->medicine_name
                . ' × '
                . $item->quantity
                . ' — Rs. '
                . number_format((float) $item->line_total, 2)
            );
        }

        if ($order->subtotal_amount !== null) {
            $mail->line(
                'Subtotal: Rs. '
                . number_format((float) $order->subtotal_amount, 2)
            );

            $mail->line(
                'VAT (' . number_format((float) $order->vat_rate, 2) . '%): Rs. '
                . number_format((float) $order->vat_amount, 2)
            );
        }

        $mail->line(
            'Grand Total: Rs. '
            . number_format((float) $order->total_amount, 2)
        );

        $mail->line(
            'Order Status: '
            . ucfirst($order->status)
        );

        $mail->action(
            'View Order',
            route('orders.show', $order)
        );

        return $mail->line(
            'Thank you for ordering from the Clinical Management System.'
        );
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
