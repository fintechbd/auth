<?php

namespace Fintech\Auth;

use App\Events\AddToFavouriteAccepted;
use App\Events\AddToFavouriteRequested;
use Fintech\Auth\Events\PasswordResetRequested;
use Fintech\Auth\Events\PasswordResetSuccessful;
use Fintech\Auth\Events\AccountFreezed;
use Fintech\Auth\Events\LoggedIn;
use Fintech\Auth\Events\LoggedOut;
use Fintech\Auth\Events\VerificationRequested;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Lockout::class => [
//            LockoutEventListener::class,
        ],
        PasswordResetRequested::class => [

        ],
        PasswordResetSuccessful::class => [

        ],
        AccountFreezed::class => [

        ],
        LoggedIn::class => [

        ],
        LoggedOut::class => [

        ],
        VerificationRequested::class => [

        ],
        AddToFavouriteRequested::class => [

        ],
        AddToFavouriteAccepted::class => [

        ]
    ];
}
