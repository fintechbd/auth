<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Abstracts\BaseEvent;
use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'Account Delete Accepted',
    description: 'Trigger fires when administrator approve user account deletion request.',
    enabled: true,
    variables: [
        new Variable(name: '__account_name__', description: 'Name of the user tried login'),
        new Variable(name: '__account_mobile__', description: 'Mobile number associate with requested user'),
        new Variable(name: '__account_email__', description: 'Email address associate with requested user'),
        new Variable(name: '__account_status__', description: 'User account before frozen/suspended status.'),
        new Variable(name: '__ip__', description: 'IP address of the request received'),
    ]
)]
class AccountDeletedAccepted extends BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     * @param Authenticatable $user
     * @param string $reason
     */
    public function __construct(public Authenticatable $user, public string $reason)
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
            '__account_name__' => $this->user->name ?? null,
            '__account_mobile__' => $this->user->mobile ?? null,
            '__account_email__' => $this->user->email ?? null,
            '__account_status__' => $this->user->status ? ucfirst($this->user->status) : null,
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
