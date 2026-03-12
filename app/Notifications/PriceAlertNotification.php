<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PriceAlertNotification extends Notification
{
    use Queueable;

    protected $alert;
    protected $price;

    /**
     * Create a new notification instance.
     */
    public function __construct($alert, $price)
    {
      $this->alert = $alert;
      $this->price = $price;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'symbol' => $this->alert->symbol,
            'condition' => $this->alert->condition,
            'target_price' => $this->alert->target_price,
            'current_price' => $this->price,
            'message' => "El precio de {$this->alert->symbol} ha cambiado a {$this->price} y es {$this->alert->condition} a {$this->alert->target_price}"
        ];
    }
}
