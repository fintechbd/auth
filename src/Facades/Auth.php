<?php

namespace Fintech\Auth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fintech\Auth\Auth
 *
 * @method static \Fintech\Auth\Services\UserService user()
 * @method static \Fintech\Auth\Services\RoleService role()
 * @method static \Fintech\Auth\Services\PermissionService permission()
 * @method static \Fintech\Auth\Services\TeamService team()
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Fintech\Auth\Auth::class;
    }
}
