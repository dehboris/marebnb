<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateReservationRequest;
use App\Reservation;
use App\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    /**
     * Process the reservation. Accept it, or deny it.
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->handle($request->get('accepted'))) {
            return redirect()->route('reservations.index')->with('success', 'Obradili ste rezervaciju.');
        } else {
            return redirect()->route('reservations.index')->with('error', 'U tom datumu već postoji prihvaćena soba.');
        }
    }

    /**
     * Edit a reservation.
     *
     * @param int $id ID of the reservation
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $reservation = Reservation::findOrFail($id);
        $rooms = Room::all();

        return view('dashboard.reservations.edit')->with('reservation', $reservation)->with('rooms', $rooms);
    }

    /**
     * Persist the reservation changes to the database.
     *
     * @param UpdateReservationRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateReservationRequest $request, int $id)
    {
        $dateStart = Carbon::createFromFormat('Y-m-d', $request->get('date_start'));
        $dateEnd = Carbon::createFromFormat('Y-m-d', $request->get('date_end'));

        if (Reservation::isOutOfRange($dateStart, $dateEnd) || Reservation::alreadyReservedInDates($dateStart, $dateEnd, $request->get('room_id'), $id)) {
            return back()->with('error', 'Soba se ne može rezervirati u ovom terminu.');
        }

        $reservation = Reservation::findOrFail($id);

        $attributes = $request->all();
        $attributes['need_tv'] = $request->has('need_tv');
        $attributes['need_wifi'] = $request->has('need_wifi');
        $attributes['need_parking'] = $request->has('need_parking');

        $reservation->update($attributes);

        return back()->with('success', 'Uspješno ste uredili rezervaciju.');
    }

    /**
     * Destroy a resource from the database.
     *
     * @param int $id ID of the resource
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Uspješno ste obrisali rezervaciju.');
    }
}