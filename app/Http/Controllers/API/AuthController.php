<?php

namespace App\Http\Controllers\API;

use App\Events\Users\UserWasRegistered;
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
            return response()->json(['data' => User::getTokenFor($request->get('email'))]);
        } else {
            return response()->json(['data' => 'E-mail ili lozinka nisu ispravni.'], 400);
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

        // event(new UserWasRegistered($user));

        $code = $user ? 200 : 400;
        $message = $user ? ['data' => $user->api_token] : ['data' => 'Greška u sustavu.'];

        return response()->json($message, $code);
    }
}