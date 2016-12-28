<?php

namespace App\Http\Controllers\API;

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

        // Find all approved reservations for this room.
        $reservations = Reservation::allApproved($request->get('room_id'));

        foreach ($reservations as $reservation) {
            // Room is already reserved?
            if ($reservation->isReserved($request->get('date_start'), $request->get('date_end'))) {
                return response()->json(['data' => 'Soba je već rezervirana u ovom terminu.'], 401);
            }
        }

        // Create new Reservation instance based from the request input
        $reservation = Reservation::createFromRequest($request);

        if ($reservation) {
            $room->reserve($reservation->date_start, $reservation->date_end);

            return response()->json(['data' => 'Rezervacija uspješna.']);
        } else {
            return response()->json(['data' => 'Greška u sustavu.'], 400);
        }
    }
}
