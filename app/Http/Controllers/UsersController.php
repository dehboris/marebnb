<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\CreateUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
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
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeAdmin(CreateUserRequest $request)
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

    /**
     * Show a form for creating new users.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.users.create');
    }

    /**
     * Persist new object to the database.
     *
     * @param CreateUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateUserRequest $request)
    {
        $user = User::createUser($request->all());

        if ($user) {
            return redirect()->route('users.index')->with('success', 'Uspješno ste novi korisnički račun s e-mail adresom: ' . $user->email);
        } else {
            return redirect()->route('users.index')->with('error', 'Greška u sustavu.');
        }
    }

    /**
     * Edit a user.
     *
     * @param int $id ID of the user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $user = User::findOrFail($id);

        return view('dashboard.users.edit')->with('user', $user);
    }

    /**
     * Persist the user changes to the database.
     *
     * @param UpdateUserRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, int $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->except('password'));

        return redirect()->back()->with('success', 'Uspješno ste uredili korisnika.');
    }

    /**
     * Destroy a resource from the database.
     *
     * @param int $id ID of the resource
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $user = User::findOrFail($id);

        // Can't delete the owner.
        if ($user->isOwner()) {
            return redirect()->route('users.index')->with('error', 'Vlasnik se ne može obrisati.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Uspješno ste obrisali korisnika te sve rezervacije asocirane za taj objekt.');
    }
}
