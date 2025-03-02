<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Abstracts\BaseEvent;
use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'Invalid Login Attempt',
    description: 'Login attempts were made with invalid (email/phone/username).',
    enabled: true,
    variables: [
        new Variable(name: '__login_id__', description: 'Email, phone number used to log in'),
        new Variable(name: '__ip__', description: 'IP address of the trigger received'),
        new Variable(name: '__platform__', description: 'User Agent/Platform of the trigger received'),
    ]
)]
class Attempting extends BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public array $credentials = [], public bool $remember = false)
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
            '__login_id__' => $this->credentials['mobile'] ?? $this->credentials['email'] ?? $this->credentials['login_id'] ?? null,
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
