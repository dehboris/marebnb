<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\Auth\LoginRequest;
use App\Http\Requests\API\Auth\RegisterRequest;
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
            return response()->json(['api_token' => null, 'errors' => 'E-mail ili lozinka nisu ispravni.']);
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
        // Create new User instance and persist it to the database
        $user = User::createUser($request->all());

        $message = $user ? ['api_token' => (string) $user->api_token, 'errors' => null] : ['errors' => 'Greška u sustavu.', 'api_token' => null];

        return response()->json($message);
    }
}