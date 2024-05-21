<?php

namespace Fintech\Auth\Providers;

use Fintech\Auth\Events\AccountFreezed;
use Fintech\Auth\Events\AddToFavouriteAccepted;
use Fintech\Auth\Events\AddToFavouriteRejected;
use Fintech\Auth\Events\AddToFavouriteRequested;
use Fintech\Auth\Events\LoggedIn;
use Fintech\Auth\Events\LoggedOut;
use Fintech\Auth\Events\PasswordResetRequested;
use Fintech\Auth\Events\PasswordResetSuccessful;
use Fintech\Auth\Events\VerificationRequested;
use Fintech\Core\Listeners\TriggerListener;
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
            TriggerListener::class
        ],
        PasswordResetRequested::class => [
            TriggerListener::class
        ],
        PasswordResetSuccessful::class => [
            TriggerListener::class
        ],
        AccountFreezed::class => [
            TriggerListener::class
        ],
        LoggedIn::class => [
            TriggerListener::class
        ],
        LoggedOut::class => [
            TriggerListener::class
        ],
        VerificationRequested::class => [
            TriggerListener::class
        ],
        AddToFavouriteRequested::class => [
            TriggerListener::class
        ],
        AddToFavouriteAccepted::class => [
            TriggerListener::class
        ],
        AddToFavouriteRejected::class => [
            TriggerListener::class
        ]
    ];
}
