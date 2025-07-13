<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Booking;

class BookingStatusNotification extends Notification
{
    use Queueable;

    public $status;
    public $booking;

    public function __construct($status, Booking $booking)
    {
        $this->status = $status;
        $this->booking = $booking;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $logoUrl = asset('storage/logo-masjid.png'); // Make sure this exists
        $greeting = "Assalamualaikum warahmatullahi wabarakatuh,";
        $name = $this->booking->name;

        $mail = (new MailMessage)
            ->greeting($greeting)
            ->subject($this->status === 'approved'
                ? 'Tempahan Anda Telah Diluluskan'
                : 'Tempahan Anda Tidak Diluluskan');

        return (new MailMessage)
            ->greeting($greeting)
            ->subject($this->status === 'approved'
                ? 'Tempahan Anda Telah Diluluskan'
                : 'Tempahan Anda Tidak Diluluskan')
            ->markdown('email.booking_notification', [
                'status' => $this->status,
                'booking' => $this->booking,
                'logoUrl' => $logoUrl,
            ]);


        return $mail;
    }
}
