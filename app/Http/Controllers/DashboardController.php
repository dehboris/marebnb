<?php

namespace App\Http\Controllers;

use App\Http\Requests\InitialSetupRequest;
use App\Reservation;
use App\Room;
use App\User;
use Auth;

class DashboardController extends Controller
{
    /**
         * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $rooms = Room::all();
        $reservations = Reservation::approved()->with('user')->get();
        $zauzece = [];

        foreach ($rooms as $room) {
            $zauzece[$room->id] = 0;
        }

        foreach ($rooms as $room) {
            foreach ($reservations as $reservation) {
                if ($reservation->room_id != $room->id) continue;

                $zauzece[$room->id] += $reservation->date_start->diffInDays($reservation->date_end) + 1;
            }
        }

        $zauzece = collect($zauzece)->filter(function ($value, $key) {
            return $value != 0;
        })->sort()->reverse()->map(function ($item, $key) use ($rooms) {
            return [
                'soba' => $rooms->where('id', $key)->first(),
                'dani' => $item
            ];
        })->values();

        // Rangiranje korisnika po drzavama i gradovima i broj dodatnih usluga koje se traze
        $drzave = [];
        $usluge = [
            'TV'      => 0,
            'WiFi'    => 0,
            'Parking' => 0
        ];

        foreach ($reservations as $reservation) {
            $drzave[] = $reservation->user->country;

            if ($reservation->need_tv) {
                $usluge['TV']++;
            }

            if ($reservation->need_parking) {
                $usluge['Parking']++;
            }

            if ($reservation->need_wifi) {
                $usluge['WiFi']++;
            }
        }

        $drzave = array_count_values($drzave);

        arsort($drzave);
        arsort($usluge);

        return view('dashboard.index')->with('zauzece', $zauzece)->with('drzave', $drzave)->with('usluge', $usluge);
    }

    /**
     * Show initial setup page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setup()
    {
        return view('dashboard.setup');
    }

    /**
     * Release application in production, for the very first time!
     * Create owner account, log him in then redirect him to the home page!
     *
     * @param InitialSetupRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function initialRelease(InitialSetupRequest $request)
    {
        if (User::ownerExists()) {
            return redirect()->route('home');
        }

        $user = User::createOwner($request->all());

        if ($user) {
            Auth::login($user);

            return redirect()->route('home')->with('success', 'Uspješno ste inicijalno puštanje aplikacije!');
        } else {
            return redirect()->route('setup')->with('error', 'Greška u sustavu.');
        }
    }
}
