<?php

namespace Fintech\Auth\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoggedIn
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

}
