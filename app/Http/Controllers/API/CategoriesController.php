<?php

namespace App\Http\Controllers\API;

use App\Category;

class CategoriesController extends Controller
{
    /**
     * Get all categories as a form of JSON array.
     *
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return Category::all();
    }
}
