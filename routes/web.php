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


Route::get('/setup', function() {
    return 'Initial admin setup!';
})->name('setup');

Route::get('/', 'DashboardController@index')->name('home')->middleware('auth');

// Users resource
Route::group(['prefix' => 'users', 'middleware' => 'auth', 'as' => 'users.'], function() {
    Route::get('/', 'UsersController@index')->name('index');
    Route::get('/create-admin', 'UsersController@createAdmin')->name('create-admin')->middleware('owner');
    Route::post('/create-admin', 'UsersController@storeAdmin')->middleware('owner');
});

// Objects object
Route::group(['prefix' => 'objects', 'middleware' => 'auth', 'as' => 'objects.'], function() {
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

// Authentication Routes...
Route::get('login', 'LoginController@showLoginForm')->name('login');
Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout')->name('logout');