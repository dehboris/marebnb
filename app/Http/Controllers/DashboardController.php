<?php

namespace App\Http\Controllers;

use App\Http\Requests\InitialSetupRequest;
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
        return view('dashboard.index');
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
