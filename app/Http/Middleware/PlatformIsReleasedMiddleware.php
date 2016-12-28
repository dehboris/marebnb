<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class PlatformIsReleasedMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->path() == 'setup') {
            return User::ownerExists() ? abort(404) : $next($request);
        } else {
            return User::ownerExists() ? $next($request) : redirect()->route('setup');
        }
    }
}
