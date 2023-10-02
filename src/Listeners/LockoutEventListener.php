<?php

namespace Fintech\Auth\Listeners;

use Illuminate\Auth\Events\Lockout;

class LockoutEventListener
{
    /**
     * Handle the event.
     */
    public function handle(Lockout $event): void
    {
        //        abort(Response::HTTP_LOCKED, trans('auth.throttle', [
        //            'seconds' => $seconds,
        //            'minutes' => ceil($seconds / 60),
        //        ]));
    }
}
