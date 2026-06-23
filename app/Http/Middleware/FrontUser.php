<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class FrontUser
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle($request, Closure $next)
    {
        
            if (Auth::check() && Auth::user()->user_type == 1) {
                return $next($request);
            } else {
                return redirect()->route('frontend.index')->with('info', 'You must log in first before proceeding');
            }
        

    }
}
