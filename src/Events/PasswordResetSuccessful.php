<?php

namespace Fintech\Auth\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
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
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
