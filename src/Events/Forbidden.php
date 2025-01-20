<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'Account Access Forbidden',
    description: 'When someone tries to login into their account without proper permission, if permission missing the trigger get fired.',
    enabled: true,
    variables: [
        new Variable(name: '__account_name__', description: 'Name of the user tried login.'),
        new Variable(name: '__account_mobile__', description: 'Mobile number associate with requested user.'),
        new Variable(name: '__account_email__', description: 'Email address associate with requested user.'),
        new Variable(name: '__permissions__', description: 'Permissions that required to authorized.'),
        new Variable(name: '__account_status__', description: 'User account before frozen/suspended status.'),
        new Variable(name: '__ip__', description: 'IP Address of the request received'),
        new Variable(name: '__platform__', description: 'User Platform of the request received'),
    ]
)]
class Forbidden extends \Fintech\Core\Abstracts\BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Authenticatable $user, public array $permissions = [])
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
            '__permissions__' => $this->permissions ?? null,
            '__account_status__' => $this->user->status ? ucfirst($this->user->status) : null,
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
