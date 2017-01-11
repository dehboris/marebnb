<?php

namespace App\Http\Controllers\API;

use App\Events\Reservations\RoomWasReserved;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\Reservations\StoreReservationRequest;
use App\Reservation;
use App\Room;

class ReservationsController extends Controller
{
    /**
     * Store a new reservation into the database.
     *
     * @param StoreReservationRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreReservationRequest $request)
    {
        $room = Room::find($request->get('room_id'));

        // Room not found? Respond with a 404.
        if (!$room) {
            return response()->json(['data' => 'Soba nije pronađena.'], 404);
        }

        // Reservation is out of range?
        if (Reservation::isOutOfRange($request->get('date_start'), $request->get('date_end'))) {
            return response()->json(['data' => 'Radno vrijeme turističkog naselja je od 1.5. do 30.9 u godini.'], 401);
        }

        if (Reservation::alreadyReservedInDates($request->get('date_start'), $request->get('date_end'), $request->get('room_id'))) {
            return response()->json(['data' => 'Soba je već rezervirana u ovom terminu.'], 401);
        }

        // Create new Reservation instance based from the request input
        $reservation = Reservation::createFromRequest($request);

        if ($reservation) {
            $room->reserve($reservation->date_start, $reservation->date_end);

            // Dispatch the RoomWasReserved event and run all event listeners
             event(new RoomWasReserved($reservation));

            return response()->json(['data' => 'Rezervacija uspješna.']);
        } else {
            return response()->json(['data' => 'Greška u sustavu.'], 400);
        }
    }
}
