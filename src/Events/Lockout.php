<?php

namespace Fintech\Auth\Events;

use Fintech\Auth\Http\Requests\LoginRequest;
use Fintech\Auth\Traits\GuessAuthFieldTrait;
use Fintech\Core\Abstracts\BaseEvent;
use Fintech\Core\Attributes\ListenByTrigger;
use Fintech\Core\Attributes\Variable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

#[ListenByTrigger(
    name: 'Login Request Lockout',
    description: 'Multiple login attempts are made in short timeframe then system blocked future requests.',
    enabled: true,
    variables: [
        new Variable(name: '__login_id__', description: 'Email, Phone number used to login'),
        new Variable(name: '__ip__', description: 'IP address of the trigger received'),
        new Variable(name: '__platform__', description: 'User Agent/Platform of the trigger received'),
        new Variable(name: '__minutes_remain__', description: 'Minutes after the system will be available.'),
    ]
)]
class Lockout extends BaseEvent
{
    use Dispatchable;
    use InteractsWithSockets;
    use SerializesModels;
    use GuessAuthFieldTrait;

    /**
     * Create a new event instance.
     */
    public function __construct(public LoginRequest $request, public int $minutes = 0)
    {
        $this->init();
    }

    public function user(): mixed
    {
        $credentials = $this->getAuthFieldFromInput($this->request);

        return \Fintech\Auth\Facades\Auth::user()->findWhere($credentials);
    }

    /**
     * List all the aliases that this event will provide
     * @return array
     */
    public function aliases(): array
    {
        return [
            '__login_id__' => $this->request->input('login_id'),
            '__minutes_remain__' => $this->minutes,
            '__ip__' => request()->ip(),
            '__platform__' => request()->userAgent(),
        ];
    }
}
