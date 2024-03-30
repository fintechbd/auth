<?php

namespace Fintech\Auth\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;

class LastLoggedOut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user('sanctum');

        \Fintech\Auth\Facades\Auth::user()->updateRaw($user->getKey(), ['logged_out_at' => now()]);

        return $next($request);
    }
}
