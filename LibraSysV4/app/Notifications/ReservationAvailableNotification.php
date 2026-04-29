<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReservationAvailableNotification extends Notification
{
    use Queueable;

    public function __construct(public Reservation $reservation)
    {
        //
    }

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Reserved Book Available')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your reserved book is now available.')
            ->line('Book: ' . $this->reservation->book->title)
            ->line('Please claim it at the library desk.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Reserved Book Available',
            'message' => 'Your reserved book "' . $this->reservation->book->title . '" is now available.',
            'book_id' => $this->reservation->book_id,
            'reservation_id' => $this->reservation->id,
        ];
    }
}