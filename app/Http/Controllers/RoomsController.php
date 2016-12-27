<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\Rooms\CreateRoomRequest;
use App\Object;
use App\Room;
use App\RoomPhoto;

class RoomsController extends Controller
{
    /**
     * Show all rooms.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.rooms.index')->with('rooms', Room::with('photos', 'object', 'category')->paginate(10));
    }

    /**
     * Show the form for creating a new room.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.rooms.create')->with(['objects' => Object::all(), 'categories' => Category::all()]);
    }

    /**
     * Persist a new room and all its photos into the database.
     *
     * @param CreateRoomRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateRoomRequest $request)
    {
        $attributes = $request->all();
        $attributes['seaside'] = !!$request->get('seaside');

        $room = Room::create($attributes);

        foreach ($request->file('photos') as $photo) {
            RoomPhoto::create([
                'room_id'  => $room->id,
                'filename' => $photo->hashName(),
            ]);

            $photo->storePublicly('rooms/' . $room->id);
        }

        if ($room) {
            return redirect()->route('rooms.index')->with('success', 'Uspješno ste dodali novu smještajnu jedinicu!');
        } else {
            return redirect()->route('rooms.index')->with('error', 'Greška u sustavu.');
        }
    }
}
