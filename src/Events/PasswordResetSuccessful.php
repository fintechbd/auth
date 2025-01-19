<?php

namespace Fintech\Auth\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetSuccessful
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public ?Authenticatable $user;

    /**
     * Create a new event instance.
     * @param Authenticatable|null $user
     */
    public function __construct(Authenticatable $user = null)
    {
        $this->user = $user;
    }

    /**
     * List all the aliases that this event will provide
     * @return array
     */
    public function aliases(): array
    {
        return [
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
