<?php

namespace App\Listeners\Reservations;

use App\Events\Reservations\RoomWasReserved;
use App\Mail\RoomWasReservedMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Mail;

class SendMailToUser
{
    /**
     * Handle the event.
     *
     * @param  RoomWasReserved  $event
     * @return void
     */
    public function handle(RoomWasReserved $event)
    {
        $reservation = $event->reservation;

        Mail::to($reservation->user)->send(new RoomWasReservedMail($reservation));
    }
}
