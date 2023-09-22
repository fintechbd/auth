<?php

namespace Fintech\Auth;

use Illuminate\Contracts\Container\BindingResolutionException;

class Auth
{
    /**
     * @return \Fintech\Auth\Services\UserService
     *
     * @throws BindingResolutionException
     */
    public function user()
    {
        return app()->make(\Fintech\Auth\Services\UserService::class);
    }

    /**
     * @return \Fintech\Auth\Services\RoleService
     *
     * @throws BindingResolutionException
     */
    public function role()
    {
        return app()->make(\Fintech\Auth\Services\RoleService::class);
    }

    /**
     * @return \Fintech\Auth\Services\PermissionService
     *
     * @throws BindingResolutionException
     */
    public function permission()
    {
        return app()->make(\Fintech\Auth\Services\PermissionService::class);
    }

    /**
     * @return \Fintech\Auth\Services\TeamService
     *
     * @throws BindingResolutionException
     */
    public function team()
    {
        return app()->make(\Fintech\Auth\Services\TeamService::class);
    }
}
