<?php

namespace Fintech\Auth;

use Fintech\Auth\Listeners\LockoutEventListener;
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
            LockoutEventListener::class,
        ],
    ];
}
