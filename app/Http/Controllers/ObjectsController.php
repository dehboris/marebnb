<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateObjectRequest;
use App\Http\Requests\UpdateObjectRequest;
use App\Object;

class ObjectsController extends Controller
{
    /**
     * Show all objects.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.objects.index')->with('objects', Object::with('rooms')->get());
    }

    /**
     * Show a form for creating new objects.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.objects.create');
    }

    /**
     * Persist new object to the database.
     *
     * @param CreateObjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateObjectRequest $request)
    {
        $object = Object::create($request->all());

        if ($object) {
            return redirect()->route('objects.index')->with('success', 'Uspješno ste dodali novi objekt imena: ' . $object->label);
        } else {
            return redirect()->route('objects.index')->with('error', 'Greška u sustavu.');
        }
    }

    /**
     * Edit a object.
     *
     * @param int $id ID of the object
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $object = Object::findOrFail($id);

        return view('dashboard.objects.edit')->with('object', $object);
    }

    /**
     * Persist the object changes to the database.
     *
     * @param UpdateObjectRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateObjectRequest $request, int $id)
    {
        $object = Object::findOrFail($id);
        $object->update($request->all());

        return redirect()->back()->with('success', 'Uspješno ste uredili objekt.');
    }

    /**
     * Destroy a resource from the database.
     *
     * @param int $id ID of the resource
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $object = Object::findOrFail($id);
        $object->delete();

        return redirect()->route('objects.index')->with('success', 'Uspješno ste obrisali objekt te sve sobe asocirane za taj objekt.');
    }
}
