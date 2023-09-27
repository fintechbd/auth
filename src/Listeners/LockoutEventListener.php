<?php

namespace Fintech\Auth\Listeners;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\HttpFoundation\Response;

class LockoutEventListener
{
    /**
     * Handle the event.
     * @param Lockout $event
     */
    public function handle(Lockout $event): void
    {
//        abort(Response::HTTP_LOCKED, trans('auth.throttle', [
//            'seconds' => $seconds,
//            'minutes' => ceil($seconds / 60),
//        ]));
    }
}
