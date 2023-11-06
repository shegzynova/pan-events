<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PaymentApprovalNot extends Notification
{
    use Queueable;

    private array $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Hello ' . $this->data['full_name'])
            ->subject('Payment Approved for ' . $this->data['event_name'])
            ->line('We hope this email finds you well. We are excited to confirm your registration for the upcoming ' . $this->data['event_name'] . ', which is scheduled to take place on ' . $this->data['event_date'] . ' at ' . $this->data['event_venue'] . '.')
            ->line('We are pleased to inform you that your payment has been successfully processed, and your registration is now confirmed.')
            ->line('Thank you for choosing our services. We look forward to welcoming you at the event!')
            ->line('If you have any questions or need further assistance, feel free to contact us.');

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
