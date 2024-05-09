<?php

namespace Fintech\Auth\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class IpAddressVerified
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (App::isProduction()) {

            return response()->json(['message' => __('auth::messages.ip_blocked', ['ip' => $request->ip()])], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}
