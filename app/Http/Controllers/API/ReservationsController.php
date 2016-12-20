<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Http\Request;

class ReservationsController extends Controller
{
    public function store(StoreReservationRequest $request)
    {
        dd($request->all());
    }
}
