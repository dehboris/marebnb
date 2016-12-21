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
            return response()->json(['api_token' => User::getTokenFor($request->get('email')), 'errors' => null]);
        } else {
            return response()->json(['errors' => 'E-mail adresa ili lozinka koje ste unijeli nisu ispravni.', 'api_token' => null], 422);
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
        $attributes['api_token'] = generate_token();
        $attributes['user_type'] = 0;

        // Create new User instance and persist it to the database
        $user = User::create($attributes);

        $code = $user ? 200 : 400;
        $message = $user ? ['api_token' => $user->api_token, 'errors' => null] : ['errors' => 'Greška u sustavu.'];

        return response()->json($message, $code);
    }
}