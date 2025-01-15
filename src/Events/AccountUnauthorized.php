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
    name: 'Account Access Unauthorized',
    description: 'When someone tries to login into their account without proper permission, if permission missing the trigger get fired.',
    enabled: true,
    variables: [
        new Variable(name: '__account_name__', description: 'Name of the user tried login.'),
        new Variable(name: '__account_mobile__', description: 'Mobile number associate with requested user.'),
        new Variable(name: '__account_email__', description: 'Email address associate with requested user.'),
        new Variable(name: '__permissions__', description: 'Permissions that required to authorized.'),
        new Variable(name: '__account_status__', description: 'User account before frozen/suspended status.'),
    ]
)]
class AccountUnauthorized implements HasDynamicString
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public $permissions;

    /**
     * Create a new event instance.
     */
    public function __construct(Authenticatable $user = null, array $permissions = [])
    {
        $this->user = $user;
        $this->permissions = $permissions;
    }

    public function aliases(): array
    {
        return [

        ];
    }
}
