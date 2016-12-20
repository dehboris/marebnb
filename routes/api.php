<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/rooms', 'RoomsController@index');
Route::get('/rooms/{id}', 'RoomsController@show')->where('id', '[0-9]+');

// Create a new reservation
Route::post('/rooms', 'ReservationsController@store')->where('id', '[0-9]+')->middleware('auth:api');

Route::get('test', function() { return 'logiran'; })->middleware('auth:api');

// Get all objects and categories
Route::get('/objects', 'ObjectsController@index');
Route::get('/categories', 'CategoriesController@index');

// Authentication routes
Route::post('/auth/login', 'AuthController@login');
Route::post('/auth/register', 'AuthController@register');