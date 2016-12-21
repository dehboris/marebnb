<?php

namespace App\Http\Controllers;

use App\Http\Requests\Categories\CreateCategoryRequest;
use App\Http\Requests\Categories\UpdateCategoryRequest;
use App\Category;

class CategoriesController extends Controller
{
    /**
     * Show all categories.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('dashboard.categories.index')->with('categories', Category::with('rooms')->get());
    }

    /**
     * Show a form for creating new categories.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Persist new category to the database.
     *
     * @param CreateCategoryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(CreateCategoryRequest $request)
    {
        $category = Category::create($request->all());

        if ($category) {
            return redirect()->route('categories.index')->with('success', 'Uspješno ste dodali novu kategoriju naziva: ' . $category->name);
        } else {
            return redirect()->route('categories.index')->with('error', 'Greška u sustavu.');
        }
    }

    /**
     * Edit a category.
     *
     * @param int $id ID of the category
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(int $id)
    {
        $category = Category::findOrFail($id);

        return view('dashboard.categories.edit')->with('category', $category);
    }

    /**
     * Persist the category changes to the database.
     *
     * @param UpdateCategoryRequest $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->back()->with('success', 'Uspješno ste uredili kategoriju.');
    }

    /**
     * Destroy a resource from the database.
     *
     * @param int $id ID of the resource
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Uspješno ste obrisali kategoriju te sve smještajne jedinice asocirane za tu kategoriju.');
    }
}
