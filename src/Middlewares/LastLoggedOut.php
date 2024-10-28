<?php

namespace Fintech\Auth\Middlewares;

use Closure;
use Fintech\Auth\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastLoggedOut
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user) {
            Auth::user()->update($user->getKey(), ['logged_out_at' => now()]);
        }

        return $next($request);
    }
}
