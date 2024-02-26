<?php

namespace Fintech\Auth\Http\Middlewares;

use Closure;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class IpAddressVerified
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (App::isProduction()) {

            return $this->banned(__('auth::messages.ip_blocked', ['ip' => $request->ip()]));
        }

        return $next($request);
    }
}
