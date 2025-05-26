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
use Fintech\Core\Abstracts\BaseModel;
use Illuminate\Database\Eloquent\Collection;

class Auth
{
    /**
     * @param $filters
     * @return UserService|Collection|BaseModel
     */
    public function user($filters = null)
    {
        return \singleton(UserService::class, $filters);
    }

    /**
     * @param $filters
     * @return ProfileService|Collection|BaseModel
     */
    public function profile($filters = null)
    {
        return \singleton(ProfileService::class, $filters);
    }

    /**
     * @param $filters
     * @return RoleService|Collection|BaseModel
     */
    public function role($filters = null)
    {
        return \singleton(RoleService::class, $filters);
    }

    /**
     * @param $filters
     * @return PermissionService|Collection|BaseModel
     */
    public function permission($filters = null)
    {
        return \singleton(PermissionService::class, $filters);
    }

    /**
     * @param $filters
     * @return TeamService|Collection|BaseModel
     */
    public function team($filters = null)
    {
        return \singleton(TeamService::class, $filters);
    }

    /**
     * @param $filters
     * @return OneTimePinService|Collection|BaseModel
     */
    public function otp($filters = null)
    {
        return \singleton(OneTimePinService::class, $filters);
    }

    /**
     * @param $filters
     * @return PasswordResetService|Collection|BaseModel
     */
    public function passwordReset($filters = null)
    {
        return \singleton(PasswordResetService::class, $filters);
    }

    /**
     * @param $filters
     * @return PinResetService|Collection|BaseModel
     */
    public function pinReset($filters = null)
    {
        return \singleton(PinResetService::class, $filters);
    }

    /**
     * @param $filters
     * @return AuditService|Collection|BaseModel
     */
    public function audit($filters = null)
    {
        return \singleton(AuditService::class, $filters);
    }

    /**
     * @param $filters
     * @return FavouriteService|Collection|BaseModel
     */
    public function favourite($filters = null)
    {
        return \singleton(FavouriteService::class, $filters);
    }

    /**
     * @param $filters
     * @return GeoIpService|Collection|BaseModel
     */
    public function geoip()
    {
        return \singleton(GeoIpService::class);
    }

    /**
     * @param $filters
     * @return LoginAttemptService|Collection|BaseModel
     */
    public function loginAttempt($filters = null)
    {
        return \singleton(LoginAttemptService::class, $filters);
    }

    //** Crud Service Method Point Do not Remove **//


}
