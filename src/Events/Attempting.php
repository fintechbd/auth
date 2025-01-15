<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Fintech\Core\Interfaces\Bell\HasDynamicString;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'Attempting',
    description: 'Attempting',
    enabled: true,
    variables: [
        new Variable(name: '__ip__', description: 'IP Address of the request received'),
        new Variable(name: '__platform__', description: 'User Platform of the request received'),
    ]
)]
class Attempting implements HasDynamicString
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * List all the aliases that this event will provide
     * @return array
     */
    public function aliases(): array
    {
        return [];
    }
}
