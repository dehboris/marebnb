<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\User;

class UsersController extends Controller
{
    /**
     * Show all users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.users.index')->with(['users' => User::paginate(10)]);
    }

    /**
     * Show form for creating new administrators.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function createAdmin()
    {
        if (User::numberOfAdmins() >= 3) {
            return redirect()->route('users.index')->with('error', 'Već postoji 3 administratora.');
        }

        return view('dashboard.users.create-admin');
    }

    /**
     * Persist new administrator to the database.
     *
     * @param StoreAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(StoreAdminRequest $request)
    {
        if (User::numberOfAdmins() >= 3) {
            return redirect()->route('users.index')->with('error', 'Već postoji 3 administratora.');
        }

        $attributes = $request->all();
        $attributes['user_type'] = 1;
        $attributes['api_token'] = str_random(60);

        $user = User::create($attributes);

        if ($user) {
            return redirect()->route('users.index')->with('success', 'Uspješno ste dodali novog administratora.');
        } else {
            return redirect()->route('users.index')->with('error', 'Greška u sustavu.');
        }
    }
}
