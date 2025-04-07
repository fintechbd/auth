<?php

namespace Fintech\Auth\Events;

use Fintech\Auth\Facades\Auth;
use Fintech\Core\Abstracts\BaseEvent;
use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'OTP Verified',
    description: 'Trigger fires when system verify the account identify and related information.',
    enabled: true,
    anonymous: true,
    variables: [
        new Variable(name: '__otp__', description: 'The Random number was sent for verification'),
        new Variable(name: '__channel__', description: 'The Medium how verification was done.'),
        new Variable(name: '__created_at__', description: 'Datetime of the verification was created.'),
        new Variable(name: '__verified_at__', description: 'Datetime of the verification was completed.'),
        new Variable(name: '__account_identity__', description: 'The information which was verified.'),
        new Variable(name: '__ip__', description: 'IP address of the request received'),
        new Variable(name: '__platform__', description: 'User Agent/Platform of the trigger received'),
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
        return match ($this->otpModel->channel) {
            'user' => Auth::user()->find($this->otpModel->email),
            'email' => (new AnonymousNotifiable())->route('mail', $this->otpModel->email),
            'mobile' => (new AnonymousNotifiable())->route('sms', $this->otpModel->email),
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
            '__otp__' => $this->otpModel->token,
            '__channel__' => ucfirst($this->otpModel->channel),
            '__created_at__' => $this->otpModel->created_at->format('c'),
            '__verified_at__' => now()->format('c'),
            '__account_identity__' => now()->format('c'),
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
