<?php

namespace Fintech\Auth;

use Fintech\Auth\Services\OneTimePinService;
use Fintech\Auth\Services\PasswordResetService;
use Fintech\Auth\Services\PermissionService;
use Fintech\Auth\Services\PinResetService;
use Fintech\Auth\Services\RoleService;
use Fintech\Auth\Services\TeamService;
use Fintech\Auth\Services\UserService;

class Auth
{
    /**
     * @return UserService
     *
     */
    public function user()
    {
        return app(UserService::class);
    }

    /**
     * @return RoleService
     *
     */
    public function role()
    {
        return app(RoleService::class);
    }

    /**
     * @return PermissionService
     *
     */
    public function permission()
    {
        return app(PermissionService::class);
    }

    /**
     * @return TeamService
     *
     */
    public function team()
    {
        return app(TeamService::class);
    }

    /**
     * @return OneTimePinService
     */
    public function otp()
    {
        return app(OneTimePinService::class);
    }

    /**
     * @return PasswordResetService
     */
    public function passwordReset()
    {
        return app(PasswordResetService::class);
    }

    /**
     * @return PinResetService
     */
    public function pinReset()
    {
        return app(PinResetService::class);
    }
}
