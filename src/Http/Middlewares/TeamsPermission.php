<?php

namespace Fintech\Auth\Http\Middlewares;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamsPermission
{
    /**
     * Handle an incoming request.
     *
     * @see https://spatie.be/docs/laravel-permission/v5/basic-usage/teams-permissions
     * @param Request $request
     * @param Closure $next
     * @return Response
     */
    public function handle($request, Closure $next)
    {
        //TODO: team ID pull to use for permissions

        return $next($request);
    }
}
