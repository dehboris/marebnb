<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $attributes = [
            'email'    => 'required',
            'password' => 'required',
        ];

        $messages = [
            'email.required'    => 'E-mail adresa ili lozinka koje ste unijeli nisu ispravni.',
            'password.required' => 'E-mail adresa ili lozinka koje ste unijeli nisu ispravni.'
        ];

        $this->validate($request, $attributes, $messages);
    }

    /**
     * Get owner's credentials (credentials + user_type = 2).
     *
     * @param Request $request
     * @return array
     */
    protected function ownerCredentials(Request $request)
    {
        $attributes = $request->only('email', 'password');
        $attributes['user_type'] = 2;

        return $attributes;
    }

    /**
     * Get admin's credentials (credentials + user_type = 1).
     *
     * @param Request $request
     * @return array
     */
    protected function adminCredentials(Request $request)
    {
        $attributes = $request->only('email', 'password');
        $attributes['user_type'] = 1;

        return $attributes;
    }

    /**
     * Attempt login using admin's or owner's credentials.
     * Can't login with user credentials.
     *
     * @param Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        return $this->guard()->attempt($this->ownerCredentials($request), $request->has('remember')) || $this->guard()->attempt($this->adminCredentials($request), $request->has('remember'));
    }
}