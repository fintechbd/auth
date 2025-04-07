<?php

namespace Fintech\Auth\Events;

use Fintech\Core\Abstracts\BaseEvent;
use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'OTP Verified',
    description: 'Trigger fires when system delete the user account and related information.',
    enabled: true,
    anonymous: true,
    variables: [
        new Variable(name: '__account_name__', description: 'Name of the user tried login'),
        new Variable(name: '__account_mobile__', description: 'Mobile number associate with requested user'),
        new Variable(name: '__account_email__', description: 'Email address associate with requested user'),
        new Variable(name: '__account_status__', description: 'User account before frozen/suspended status.'),
        new Variable(name: '__ip__', description: 'IP address of the request received'),
    ]
)]
class OtpVerified extends BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;

    /**
     * Create a new event instance.
     * @param mixed $otpModel
     */
    public function __construct(public mixed $otpModel)
    {
        $this->init();
    }

    public function user(): mixed
    {
        return match ($this->otpInfo['auth_key']) {
//            'user' => Auth::user()->find($this->otpInfo['auth_value']),
//            'email' => (new AnonymousNotifiable())->route('mail', $this->otpInfo['auth_value']),
//            'mobile' => (new AnonymousNotifiable())->route('sms', $this->otpInfo['auth_value']),
            default => null,
        };
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
