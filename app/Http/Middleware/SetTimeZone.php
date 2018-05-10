<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class SetTimeZone
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            date_default_timezone_set(Auth::user()->timezone);
        }

        return $next($request);
    }
}
