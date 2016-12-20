<?php

namespace App\Http\Controllers\API;

use App\Object;

class ObjectsController extends Controller
{
    /**
     * Return all objects as a JSON array.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Object::all();
    }
}

