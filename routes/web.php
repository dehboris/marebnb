<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'DashboardController@index')->name('home')->middleware('auth');
Route::get('/setup', 'DashboardController@setup')->name('setup');
Route::post('/setup', 'DashboardController@initialRelease');

// Users resource
Route::group(['prefix' => 'users', 'middleware' => 'auth', 'as' => 'users.'], function () {
    Route::get('/', 'UsersController@index')->name('index');

    // Create new administrator
    Route::get('/create-admin', 'UsersController@createAdmin')->name('create-admin')->middleware('owner');
    Route::post('/create-admin', 'UsersController@storeAdmin')->middleware('owner');

    // Create and store new user
    Route::get('/create', 'UsersController@create')->name('create')->middleware('owner');
    Route::post('/', 'UsersController@store')->name('store')->middleware('owner');

    // Edit and update the user
    Route::get('/{id}', 'UsersController@edit')->name('edit')->where('id', '[0-9]+')->middleware('owner');
    Route::put('/{id}', 'UsersController@update')->name('update')->where('id', '[0-9]+')->middleware('owner');

    // Destroy the resource
    Route::delete('/{id}', 'UsersController@destroy')->name('destroy')->where('id', '[0-9]+')->middleware('owner');
});

// Reservations resource
Route::group(['prefix' => 'reservations', 'middleware' => 'auth', 'as' => 'reservations.'], function () {
    Route::get('/', 'ReservationsController@index')->name('index');
});

// Rooms resource
Route::group(['prefix' => 'rooms', 'middleware' => 'auth', 'as' => 'rooms.'], function () {
    Route::get('/', 'RoomsController@index')->name('index');

    // Create and store the room
    Route::get('/create', 'RoomsController@create')->name('create')->middleware('owner');
    Route::post('/', 'RoomsController@store')->name('store')->middleware('owner');

    // Edit and update the room
    Route::get('/{id}', 'RoomsController@edit')->name('edit')->where('id', '[0-9]+')->middleware('owner');
    Route::put('/{id}', 'RoomsController@update')->name('update')->where('id', '[0-9]+')->middleware('owner');

    // Delete the resource
    Route::delete('/{id}', 'RoomsController@destroy')->name('destroy')->where('id', '[0-9]+')->middleware('owner');
});

// Objects resource
Route::group(['prefix' => 'objects', 'middleware' => 'auth', 'as' => 'objects.'], function () {
    Route::get('/', 'ObjectsController@index')->name('index');

    // Create and store the object
    Route::get('/create', 'ObjectsController@create')->name('create')->middleware('owner');
    Route::post('/', 'ObjectsController@store')->name('store')->middleware('owner');

    // Edit and update the object
    Route::get('/{id}', 'ObjectsController@edit')->name('edit')->where('id', '[0-9]+')->middleware('owner');
    Route::put('/{id}', 'ObjectsController@update')->name('update')->where('id', '[0-9]+')->middleware('owner');

    // Destroy the object
    Route::delete('/{id}', 'ObjectsController@destroy')->name('destroy')->where('id', '[0-9]+')->middleware('owner');
});

// Categories resource
Route::group(['prefix' => 'categories', 'middleware' => 'auth', 'as' => 'categories.'], function () {
    Route::get('/', 'CategoriesController@index')->name('index');

    // Create and store the resource
    Route::get('/create', 'CategoriesController@create')->name('create')->middleware('owner');
    Route::post('/', 'CategoriesController@store')->name('store')->middleware('owner');

    // Edit and update the resource
    Route::get('/{id}', 'CategoriesController@edit')->name('edit')->where('id', '[0-9]+')->middleware('owner');
    Route::put('/{id}', 'CategoriesController@update')->name('update')->where('id', '[0-9]+')->middleware('owner');

    // Destroy the resource
    Route::delete('/{id}', 'CategoriesController@destroy')->name('destroy')->where('id', '[0-9]+')->middleware('owner');
});

// Authentication Routes...
Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout')->name('logout');