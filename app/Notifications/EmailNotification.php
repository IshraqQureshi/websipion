<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $domain;
    public $ccRecipients;

    public function __construct($domain, $ccRecipients)
    {
        $this->domain = $domain;
        $this->ccRecipients = $ccRecipients;
        // dd($ccRecipients);
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
        $ccAddresses = explode(',', $this->ccRecipients);
        $mailMessage = (new MailMessage)
            ->subject('Alert! ' . $this->domain . ' seems to be down')
            ->view('emails', ['actionUrl' => $this->domain]);

        foreach ($ccAddresses as $ccAddress) {
            if (!empty($ccAddress)) {
                $mailMessage->cc($ccAddress);
            }
        }
        return $mailMessage;
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
