<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckUserDeleted
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
        if (auth()->check() && (auth()->user()->is_deleted)) {
            auth()->logout();

            $message = 'Your account has been disabled. Please contact the Administrator.';

            return redirect()->route('login')->withMessage($message);
        }

        return $next($request);
    }
}
