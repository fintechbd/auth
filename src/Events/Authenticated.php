<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Fintech\Core\Interfaces\Bell\HasDynamicString;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'Login Successful',
    description: 'Trigger fires when user successfully to authentication with credentials on system',
    enabled: true,
    variables: [
        new Variable(name: '__account_name__', description: 'Name of the user tried login'),
        new Variable(name: '__account_mobile__', description: 'Mobile number associate with requested user'),
        new Variable(name: '__account_email__', description: 'Email address associate with requested user'),
        new Variable(name: '__password_attempt_count__', description: 'Number of times wrong password attempted'),
        new Variable(name: '__account_status__', description: 'User account before frozen/suspended status.'),
        new Variable(name: '__ip__', description: 'IP Address of the request received'),
        new Variable(name: '__platform__', description: 'User Platform of the request received'),
    ]
)]
class Authenticated implements HasDynamicString
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     * @param Authenticatable $user
     */
    public function __construct(public Authenticatable $user)
    {
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
