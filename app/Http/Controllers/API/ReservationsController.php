<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Reservation;

class ReservationsController extends Controller
{
    public function store(StoreReservationRequest $request)
    {
        $reservations = Reservation::whereNotNull('approved_at')->where('room_id', $request->get('room_id'));

        dd($request->all());
    }
}
