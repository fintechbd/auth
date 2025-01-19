<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Fintech\Core\Interfaces\Bell\HasDynamicString;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'User Account Frozen/Suspended',
    description: 'When someone tries to login into their account using incorrect password, when trials exceeds the threshold the trigger get fired.',
    enabled: true,
    variables: [
        new Variable(name: '__account_name__', description: 'Name of the user tried login.'),
        new Variable(name: '__account_mobile__', description: 'Mobile number associate with requested user.'),
        new Variable(name: '__account_email__', description: 'Email address associate with requested user.'),
        new Variable(name: '__password_attempt_count__', description: 'Number of times wrong password attempted.'),
        new Variable(name: '__account_status__', description: 'User account before frozen/suspended status.'),
        new Variable(name: '__password_attempt_limit__', description: 'The maximum number of times a user may try to customize my system.'),
    ]
)]
class Freezed implements HasDynamicString
{
    use Dispatchable;
    use SerializesModels;

    public mixed $user;

    /**
     * Create a new event instance.
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    public function aliases(): array
    {
        return [
            '__account_name__' => $this->user->name ?? '',
            '__account_mobile__' => $this->user->mobile ?? '',
            '__account_email__' => $this->user->email ?? '',
            '__password_attempt_count__' => $this->user->wrong_password ?? '',
            '__account_status__' => $this->user->status ?? '',
            '__password_attempt_limit__' => config('fintech.auth.password_threshold', 10),
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
