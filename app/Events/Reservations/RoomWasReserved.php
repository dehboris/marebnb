<?php

namespace App\Events\Reservations;

use App\Reservation;
use Illuminate\Queue\SerializesModels;

class RoomWasReserved
{
    use SerializesModels;

    /**
     * Reserved room instance.
     *
     * @var Reservation
     */
    public $reservation;

    /**
     * Create a new event instance.
     *
     * @param Reservation $reservation
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }
}
