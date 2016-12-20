<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\User;
use Auth;

class AuthController extends Controller
{
    /**
     * Authenticates user and returns API token if validated.
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        if (Auth::validate($request->only('email', 'password'))) {
            return response()->json(['api_token' => User::getTokenFor($request->get('email'))]);
        } else {
            return response()->json(['errors' => 'Invalid credentials.'], 401);
        }
    }

    /**
     * Registers a new user.
     *
     * @param RegisterRequest $request Request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        $attributes = $request->all();
        $attributes['api_token'] = str_random(60);

        // Create new User instance and persist it to the database
        $user = User::create($attributes);

        if ($user) {
            return response()->json(['api_token' => $user->api_token]);
        } else {
            return response()->json(['errors' => 'Error registering user.'], 400);
        }
    }
}
