<?php

namespace Fintech\Auth\Facades;

use Fintech\Auth\Services\AuditService;
use Fintech\Auth\Services\FavouriteService;
use Fintech\Auth\Services\IdDocTypeService;
use Fintech\Auth\Services\OneTimePinService;
use Fintech\Auth\Services\PasswordResetService;
use Fintech\Auth\Services\PermissionService;
use Fintech\Auth\Services\PinResetService;
use Fintech\Auth\Services\ProfileService;
use Fintech\Auth\Services\RoleService;
use Fintech\Auth\Services\TeamService;
use Fintech\Auth\Services\UserService;
use Illuminate\Support\Facades\Facade;

/**
 * @method static UserService user()
 * @method static ProfileService profile()
 * @method static RoleService role()
 * @method static PermissionService permission()
 * @method static TeamService team()
 * @method static OneTimePinService otp()
 * @method static PasswordResetService passwordReset()
 * @method static PinResetService pinReset()
 * @method static AuditService audit()
 * @method static IdDocTypeService idDocType()
 * @method static FavouriteService favourite()
 * // Crud Service Method Point Do not Remove //
 *
 * @see \Fintech\Auth\Auth
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Fintech\Auth\Auth::class;
    }
}
