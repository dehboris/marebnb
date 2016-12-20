<?php

namespace App\Http\Controllers;

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
        return Room::allFree();
    }

    /**
     * Show all rooms but paginate them.
     *
     * @return mixed
     */
    public function all()
    {
        return Room::paginate(10);
    }

    /**
     * Show a room with specific ID. If not found, return JSON error with 404 status code.
     *
     * @param int $id ID of the room
     * @return Room|\Illuminate\Database\Eloquent\Builder|\Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return Room::with('object', 'category')->find($id) ?: response()->json(["errors" => "Room with an ID of $id not found."], 404);
    }

    /**
     * Filter rooms using requests. If there are no rooms found, return error message.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filter(Request $request)
    {
        $query = Room::select(DB::raw('*'));

        if (($request->has('object_id') && !is_numeric($request->get('object_id'))) || ($request->has('category_id') && !is_numeric($request->get('category_id')))) {
            return response()->json(['errors' => 'No rooms found.'], 404);
        }

        foreach (['object_id', 'category_id', 'seaside', 'min_people', 'max_people'] as $rule) {
            if ($request->has($rule)) {
                $query = $query->where($rule, $request->get($rule));
            }
        };

        if ($request->has('price') && $request->has('price_type')) {
            $query = $query->where('price', $request->get('price_type'), $request->get('price'));
        }

        $results = $query->get();

        return $results->count() != 0 ? $results : response()->json(['errors' => 'No rooms found.'], 404);
    }
}
