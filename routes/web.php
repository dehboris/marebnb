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

Route::get('/', 'DashboardController@index')->name('home');

// Users resource
Route::group(['prefix' => 'users', 'middleware' => 'auth', 'as' => 'users.'], function() {
    Route::get('/', 'UsersController@index')->name('index');
    Route::get('/create-admin', 'UsersController@createAdmin')->name('create-admin')->middleware('owner');
    Route::post('/create-admin', 'UsersController@storeAdmin')->middleware('owner');
});

// Objects resource
Route::group(['prefix' => 'objects', 'middleware' => 'auth', 'as' => 'objects.'], function() {
    Route::get('/', 'ObjectsController@index')->name('index');

    // Create and store the resource
    Route::get('/create', 'ObjectsController@create')->name('create');
    Route::post('/', 'ObjectsController@store')->name('store');

    // Edit and update the resource
    Route::get('/{id}', 'ObjectsController@edit')->name('edit')->where('id', '[0-9]+');
    Route::put('/{id}', 'ObjectsController@update')->name('update')->where('id', '[0-9]+');

    // Destroy the resource
    Route::delete('/{id}', 'ObjectsController@destroy')->name('destroy')->where('id', '[0-9]+');
});

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
//Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
//Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
//Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm');
//Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail');
//Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
//Route::post('password/reset', 'Auth\ResetPasswordController@reset');