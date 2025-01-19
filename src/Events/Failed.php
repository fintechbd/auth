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
    name: 'Login Failed',
    description: 'Trigger fires when user failed to authentication with credentials on system',
    enabled: true,
    variables: [
        new Variable(name: '__account_name__', description: 'Name of the user tried login'),
        new Variable(name: '__account_mobile__', description: 'Mobile number associate with requested user'),
        new Variable(name: '__account_email__', description: 'Email address associate with requested user'),
        new Variable(name: '__password_attempt_count__', description: 'Number of times wrong password attempted'),
        new Variable(name: '__account_status__', description: 'User account before frozen/suspended status.'),
        new Variable(name: '__password_attempt_limit__', description: 'The maximum number of times a user may try to customize my system'),
        new Variable(name: '__ip__', description: 'IP Address of the request received'),
        new Variable(name: '__platform__', description: 'User Platform of the request received'),
    ]
)]
class Failed extends \Fintech\Core\Abstracts\BaseEvent implements HasDynamicString
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     * @param Authenticatable $user
     * @param array $credentials
     */
    public function __construct(public Authenticatable $user,
                                public array           $credentials = [])
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
            '__password_attempt_count__' => $this->user->wrong_password ?? null,
            '__password_attempt_limit__' => config('fintech.auth.password_threshold', 10),
            '__account_status__' => $this->user->status ? ucfirst($this->user->status) : null,
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
