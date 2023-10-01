<?php

namespace Fintech\Auth\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Fintech\Core\Traits\ApiResponseTrait;

class IpAddressVerified
{
    use ApiResponseTrait;

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (App::isProduction()) {

            return $this->banned(__('auth::messages.ip_blocked', ['ip' => $request->ip()]));
        }

        return $next($request);
    }
}
