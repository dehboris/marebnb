<?php

namespace App\Mail;

use App\Reservation;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoomWasReservedMail extends Mailable
{
    use SerializesModels;

    /**
     * Reserved room instance.
     *
     * @var Reservation
     */
    public $reservation;

    /**
     * Create a new message instance.
     *
     * @param Reservation $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.reservations.new');
    }
}
