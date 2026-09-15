<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class StaffAccountCreated extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected string $employeeId,
        protected string $role,
        protected string $resetUrl
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Your Staff Account Has Been Created')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your staff account has been created successfully.')
            ->line('Employee ID: ' . $this->employeeId)
            ->line('Role: ' . ucfirst($this->role))
            ->line('Please set your password using the button below.')
            ->action(
                'Set Your Password',
                $this->resetUrl
            )
            ->line('If you did not expect this account, please contact the administrator.');
    }

    public function toArray(object $notifiable): array
    {
        return [];
    }
}
