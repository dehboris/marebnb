<?php

namespace App\Http\Controllers;

use App\Room;

class RoomsController extends Controller
{
    /**
     * Show all rooms.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.rooms.index')->with('rooms', Room::paginate(10));
    }
}
