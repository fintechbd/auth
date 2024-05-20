<?php

namespace Fintech\Auth;

use Fintech\Auth\Services\AuditService;
use Fintech\Auth\Services\FavouriteService;
use Fintech\Auth\Services\IpAddressService;
use Fintech\Auth\Services\OneTimePinService;
use Fintech\Auth\Services\PasswordResetService;
use Fintech\Auth\Services\PermissionService;
use Fintech\Auth\Services\PinResetService;
use Fintech\Auth\Services\ProfileService;
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
     * @return UserService
     *
     */
    public function profile()
    {
        return app(ProfileService::class);
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

    /**
     * @return AuditService
     */
    public function audit()
    {
        return app(AuditService::class);
    }

    /**
     * @return FavouriteService
     */
    public function favourite()
    {
        return app(FavouriteService::class);
    }

    /**
     * @return IpAddressService
     */
    public function ipAddress()
    {
        return app(IpAddressService::class);
    }

    //** Crud Service Method Point Do not Remove **//


}
