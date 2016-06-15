<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
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
        if (Auth::check()  == 1 && (Auth::user()->ruls == 1 || Auth::user()->ruls == 2)){
            return $next($request);
        } else {
            return redirect()->guest('login');
        }
    }
}
