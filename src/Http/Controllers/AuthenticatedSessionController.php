<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Enums\UserStatus;
use Fintech\Auth\Http\Requests\LoginRequest;
use Fintech\Auth\Http\Resources\LoginResource;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    use ApiResponseTrait;

    /**
     * Handle an incoming authentication request.
     *
     * @throws ValidationException
     */
    public function store(LoginRequest $request): LoginResource|JsonResponse
    {
        $request->ensureIsNotRateLimited();

        $attemptUser = \Fintech\Auth\Facades\Auth::user()->list([
            'login_id' => $request->input('login_id'),
            'paginate' => false,
        ]);

        if ($attemptUser->isEmpty()) {

            return $this->failed(__('auth::messages.failed'));
        }

        $attemptUser = $attemptUser->first();

        if ($attemptUser->wrong_password > config('fintech.auth.threshold.password', 10)) {

            \Fintech\Auth\Facades\Auth::user()->update($attemptUser->id, [
                'status' => UserStatus::InActive->value,
            ]);

            return $this->failed(__('auth::messages.lockup'));
        }

        if (! Hash::check($request->input('password'), $attemptUser->password)) {

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

        Auth::login($attemptUser);

        Auth::user()->tokens->each(fn ($token) => $token->delete());

        //permission check

        return new LoginResource(Auth::user());
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(): JsonResponse
    {
        Auth::guard('web')->logout();

        return $this->deleted(__('auth::messages.logout'));
    }
}
