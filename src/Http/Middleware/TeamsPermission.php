<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TeamsPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return Response
     */
    public function handle($request, \Closure $next)
    {
        if (! empty(auth('api')->user())) {
            setPermissionsTeamId(auth('api')->user()->getTeamIdFromToken());
        }

        return $next($request);
    }
}
