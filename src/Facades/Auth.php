<?php

namespace Fintech\Auth\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Fintech\Auth\Auth
 */
class Auth extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Fintech\Auth\Auth::class;
    }
}
