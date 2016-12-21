<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class IsOwnerMiddleware
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
        if (!Auth::check() || !Auth::user()->isOwner()) {
            return abort(403);
        }

        return $next($request);
    }
}
