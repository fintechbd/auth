<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'Attempting',
    description: 'Attempting',
    enabled: true,
    variables: [
        new Variable(name: '__login_id__', description: 'Email, phone number used to log in'),
        new Variable(name: '__ip__', description: 'IP Address of the request received'),
        new Variable(name: '__platform__', description: 'User Platform of the request received'),
    ]
)]
class Attempting extends \Fintech\Core\Abstracts\BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public string $guard = 'web', public array $credentials = [], public bool $remember = false)
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
            '__login_id__' => $this->credentials[config('fintech.auth.auth_field', 'login_id')],
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
