<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_deleted) {
            auth()->logout();

            $message = 'Your account has been suspended. Please contact administrator.';

            return redirect()->route('login')->withMessage($message);
        }

        if( Auth::check() && (Auth::user()->role=='Admin'))
        {
            return $next($request);
        }

        return redirect()->back();
    }
}
