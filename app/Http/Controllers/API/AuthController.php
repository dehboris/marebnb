<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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
        $attributes = $request->except('user_type');
        $attributes['api_token'] = str_random(60);
        $attributes['user_type'] = 0;

        // Create new User instance and persist it to the database
        $user = User::create($attributes);

        $code = $user ? 200 : 400;
        $message = $user ? ['api_token' => $user->api_token] : ['errors' => 'Error registering user.'];

        return response()->json($message, $code);
    }
}