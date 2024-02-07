<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SSLCertificateExpiry extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $domain;
    public $msg;
    public $name;

    public function __construct($domain, $msg, $name)
    {
        $this->domain = $domain;
        $this->msg = $msg;
        $this->name = $name;
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
            ->subject("SSL Certificate Expired!")
            ->greeting('Hi, ' . $this->name)
            ->line($this->msg)
            ->action('Check', $this->domain)
            ->line('Thanks.');
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
