<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Reservation;
use App\Room;
use Auth;
use Carbon\Carbon;

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
        $user = Auth::guard('api')->user();
        $room = Room::find($request->get('room_id'));

        // Room not found? Respond with a 404.
        if (!$room) {
            return response()->json(['errors' => 'Soba nije pronađena.'], 404);
        }

        // Find all approved reservations for this room.
        $reservations = Reservation::whereNotNull('approved_at')->where('room_id', $request->get('room_id'))->get();

        $dateStart = Carbon::createFromTimestamp($request->get('date_start'));
        $dateEnd = Carbon::createFromTimestamp($request->get('date_end'));

        foreach ($reservations as $reservation) {
            if (($dateStart->gte($reservation->date_start) && $dateStart->lte($reservation->date_end)) || ($dateEnd->gte($reservation->date_start) && $dateEnd->lte($reservation->date_end)) || ($dateStart->lt($reservation->date_start) && $dateEnd->gt($reservation->date_end))) {
                return response()->json(['errors' => 'Soba je već rezervirana u ovom terminu.'], 401);
            }
        }

        $attributes = $request->all();
        $attributes['user_id'] = $user->id;
        $attributes['approved_at'] = null;
        $reservation = Reservation::create($attributes);

        if ($reservation) {
            $room->reserve($reservation->date_start, $reservation->date_end);

            return response()->json(['success' => 'Rezervacija uspješna.']);
        } else {
            return response()->json(['errors' => 'Greška u sustavu.'], 400);
        }
    }
}
