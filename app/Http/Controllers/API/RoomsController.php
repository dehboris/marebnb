<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Room;
use DB;
use Illuminate\Http\Request;

class RoomsController extends Controller
{
    /**
     * Show all available rooms.
     *
     * @return mixed
     */
    public function index()
    {
        return Room::getAllRooms();
    }

    /**
     * Show a room with specific ID. If not found, return JSON error with 404 status code.
     *
     * @param int $id ID of the room
     * @return Room|\Illuminate\Database\Eloquent\Builder|\Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return Room::with('object', 'category')->find($id) ?: response()->json(["errors" => "Soba s ID $id nije pronađena."], 404);
    }
}
