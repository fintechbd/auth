<?php

namespace Fintech\Auth\Providers;

use Fintech\Auth\Events\Authenticated;
use Fintech\Auth\Events\Freezed;
use Fintech\Auth\Events\AddToFavouriteAccepted;
use Fintech\Auth\Events\AddToFavouriteRejected;
use Fintech\Auth\Events\AddToFavouriteRequested;
use Fintech\Auth\Events\PasswordResetRequested;
use Fintech\Auth\Events\PasswordResetSuccessful;
use Fintech\Auth\Events\VerificationRequested;
use Fintech\Core\Listeners\TriggerNotification;
use Illuminate\Auth\Events\Attempting;
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
            TriggerNotification::class
        ],
        Attempting::class => [
            TriggerNotification::class
        ],
        PasswordResetRequested::class => [
            TriggerNotification::class
        ],
        PasswordResetSuccessful::class => [
            TriggerNotification::class
        ],
        Freezed::class => [
            TriggerNotification::class
        ],
        Authenticated::class => [
            TriggerNotification::class
        ],
        VerificationRequested::class => [
            TriggerNotification::class
        ],
        AddToFavouriteRequested::class => [
            TriggerNotification::class
        ],
        AddToFavouriteAccepted::class => [
            TriggerNotification::class
        ],
        AddToFavouriteRejected::class => [
            TriggerNotification::class
        ]
    ];
}
