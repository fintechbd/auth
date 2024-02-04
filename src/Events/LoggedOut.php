<?php

namespace Fintech\Auth\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LoggedOut
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Authenticatable $user;

    /**
     * Create a new event instance.
     * @param Authenticatable $user
     */
    public function __construct(Authenticatable $user)
    {
        $this->user = $user;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
