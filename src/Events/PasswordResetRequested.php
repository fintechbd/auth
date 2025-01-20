<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Abstracts\BaseEvent;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PasswordResetRequested extends BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    public $user;

    /**
     * Create a new event instance.
     * @param Authenticatable|null $user
     */
    public function __construct($user)
    {
        $this->user = $user;
        $this->init();
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
