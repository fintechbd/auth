<?php

namespace Fintech\Auth\Http\Middlewares;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LastLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, \Closure $next)
    {
        return $next($request);
    }

    /**
     * Handle an outgoing response.
     *
     * @param Request $request
     * @param $response
     */
    public function terminate(Request $request, $response): void
    {
        $user = \Illuminate\Support\Facades\Auth::user();

        if ($user) {
            \Fintech\Auth\Facades\Auth::user()->updateRaw($user->getKey(), ['logged_in_at' => now()]);
        }
    }
}
