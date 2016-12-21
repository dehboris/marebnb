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
        if (User::numberOfAdmins() >= config('site.max_admins')) {
            return redirect()->route('users.index')->with('error', 'Već postoji ' . config('site.max_admins') . ' administratora.');
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
        if (User::numberOfAdmins() >= config('site.max_admins')) {
            return redirect()->route('users.index')->with('error', 'Već postoji ' . config('site.max_admins') . ' administratora.');
        }

        if (User::createAdmin($request->all())) {
            return redirect()->route('users.index')->with('success', 'Uspješno ste dodali novog administratora.');
        } else {
            return redirect()->route('users.index')->with('error', 'Greška u sustavu.');
        }
    }
}
