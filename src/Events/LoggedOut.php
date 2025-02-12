<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'LoggedOut',
    description: 'LoggedOut',
    enabled: true,
    variables: [
        new Variable(name: '__ip__', description: 'IP Address of the request received')
    ]
)]
class LoggedOut extends \Fintech\Core\Abstracts\BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct()
    {
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
