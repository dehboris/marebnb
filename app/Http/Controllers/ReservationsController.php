<?php

namespace App\Http\Controllers;

use App\Reservation;

class ReservationsController extends Controller
{
    /**
     * Show all reservations.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.reservations.index')->with('reservations', Reservation::with('user', 'room')->paginate(10));
    }
}