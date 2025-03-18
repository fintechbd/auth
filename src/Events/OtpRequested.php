<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Abstracts\BaseEvent;
use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'OTP Requested',
    description: 'Trigger fires when system delete the user account and related information.',
    enabled: true,
    anonymous: true,
    variables: [
        new Variable(name: '__otp__', description: 'Random number that generated for verification'),
        new Variable(name: '__account_mobile__', description: 'Mobile number associate with requested user'),
        new Variable(name: '__account_email__', description: 'Email address associate with requested user'),
        new Variable(name: '__account_status__', description: 'User account before frozen/suspended status.'),
        new Variable(name: '__ip__', description: 'IP address of the request received'),
    ]
)]
class OtpRequested extends BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     * @param array $otpInfo
     */
    public function __construct(public array $otpInfo = [])
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
            '__otp__' => $this->otpInfo['value'] ?? null,
            '__expired_at__' => now()->addMinutes(config('auth.passwords.users.expire'))->format('r'),
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
