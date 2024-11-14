<?php

namespace Fintech\Auth;

use Fintech\Auth\Services\AuditService;
use Fintech\Auth\Services\FavouriteService;
use Fintech\Auth\Services\GeoIpService;
use Fintech\Auth\Services\LoginAttemptService;
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
    public function user($filters = null)
    {
        return \singleton(UserService::class, $filters);
    }


    public function profile($filters = null)
    {
        return \singleton(ProfileService::class, $filters);
    }


    public function role($filters = null)
    {
        return \singleton(RoleService::class, $filters);
    }


    public function permission($filters = null)
    {
        return \singleton(PermissionService::class, $filters);
    }


    public function team($filters = null)
    {
        return \singleton(TeamService::class, $filters);
    }

    public function otp($filters = null)
    {
        return \singleton(OneTimePinService::class, $filters);
    }

    public function passwordReset($filters = null)
    {
        return \singleton(PasswordResetService::class, $filters);
    }

    public function pinReset($filters = null)
    {
        return \singleton(PinResetService::class, $filters);
    }

    public function audit($filters = null)
    {
        return \singleton(AuditService::class, $filters);
    }

    public function favourite($filters = null)
    {
        return \singleton(FavouriteService::class, $filters);
    }

    public function geoip()
    {
        return \singleton(GeoIpService::class);
    }

    public function loginAttempt($filters = null)
    {
        return \singleton(LoginAttemptService::class, $filters);
    }

    //** Crud Service Method Point Do not Remove **//


}
