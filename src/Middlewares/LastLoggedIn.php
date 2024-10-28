<?php

namespace Fintech\Auth\Middlewares;

use Closure;
use Fintech\Auth\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LastLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next)
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
            Auth::user()->update($user->getKey(), ['logged_in_at' => now()]);
        }
    }
}
