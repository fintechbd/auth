<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Enums\UserStatus;
use Fintech\Auth\Events\AccountFreezed;
use Fintech\Auth\Http\Requests\LoginRequest;
use Fintech\Auth\Http\Resources\LoginResource;
use Fintech\Auth\Traits\GuessAuthFieldTrait;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    use ApiResponseTrait;
    use GuessAuthFieldTrait;

    /**
     * Handle an incoming authentication request.
     *
     * @param LoginRequest $request
     * @return LoginResource|JsonResponse
     * @throws ValidationException
     */
    public function store(LoginRequest $request): LoginResource|JsonResponse
    {
        $request->ensureIsNotRateLimited();

        $attemptUser = \Fintech\Auth\Facades\Auth::user()->list($this->getAuthFieldFromInput($request));

        if ($attemptUser->isEmpty()) {

            return $this->failed(__('auth::messages.failed'));
        }

        $attemptUser = $attemptUser->first();

        if ($attemptUser->wrong_password > config('fintech.auth.password_threshold', 10)) {

            \Fintech\Auth\Facades\Auth::user()->update($attemptUser->id, [
                'status' => UserStatus::InActive->value,
            ]);

            AccountFreezed::dispatch($attemptUser);

            return $this->failed(__('auth::messages.lockup'));
        }

        $passwordField = config('fintech.auth.password_field', 'password');

        if (!Hash::check($request->input($passwordField), $attemptUser->{$passwordField})) {

            $request->hitRateLimited();

            $wrongPasswordCount = $attemptUser->wrong_password + 1;

            \Fintech\Auth\Facades\Auth::user()->update($attemptUser->id, [
                'wrong_password' => $wrongPasswordCount,
            ]);

            return $this->failed(__('auth::messages.warning', [
                'attempt' => $wrongPasswordCount,
                'threshold' => config('fintech.auth.threshold.password', 10),
            ]));
        }

        $request->clearRateLimited();

        if (!$attemptUser->can('auth.login')) {
            $request->session()->invalidate();

            return $this->forbidden(__('auth::messages.forbidden', ['permission' => permission_format('auth.login', 'auth')]));
        }

        Auth::login($attemptUser);

        $attemptUser->tokens->each(fn($token) => $token->delete());

        return new LoginResource($attemptUser);
    }

    /**
     * Destroy an authenticated session
     */
    public function destroy(): JsonResponse
    {
        Auth::guard('web')->logout();

        return $this->deleted(__('auth::messages.logout'));
    }
}
