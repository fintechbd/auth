<?php

namespace Fintech\Auth;

use Fintech\Auth\Services\PermissionService;
use Fintech\Auth\Services\RoleService;
use Fintech\Auth\Services\TeamService;
use Fintech\Auth\Services\UserService;
use Illuminate\Contracts\Container\BindingResolutionException;

class Auth
{
    /**
     * @return UserService
     *
     * @throws BindingResolutionException
     */
    public function user()
    {
        return app(UserService::class);
    }

    /**
     * @return RoleService
     *
     * @throws BindingResolutionException
     */
    public function role()
    {
        return app(RoleService::class);
    }

    /**
     * @return PermissionService
     *
     * @throws BindingResolutionException
     */
    public function permission()
    {
        return app(PermissionService::class);
    }

    /**
     * @return TeamService
     *
     * @throws BindingResolutionException
     */
    public function team()
    {
        return app(TeamService::class);
    }
}
