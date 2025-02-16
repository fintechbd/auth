<?php

namespace Fintech\Auth\Http\Requests;

use Fintech\Auth\Events\Lockout;
use Fintech\Core\Facades\Core;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $defaultRules = [
            config('fintech.auth.auth_field', 'login_id') => config('fintech.auth.auth_field_rules', ['required', 'string', 'min:6', 'max:255']),
            config('fintech.auth.password_field', 'password') => config('fintech.auth.password_field_rules', ['required', 'string', 'min:8']),
        ];

        if (Core::packageExists('Bell')) {
            $defaultRules['fcm_token'] = ['nullable', 'string', 'max:255'];
        }

        return $defaultRules;
    }

    /**
     * clear the rate limiter if authenticated
     */
    public function clearRateLimited(): void
    {
        RateLimiter::clear(throttle_key());
    }

    /**
     * count the rate limiter if authenticated
     */
    public function hitRateLimited(): void
    {
        RateLimiter::hit(throttle_key());
    }

    /**
     * Ensure the login request is not rate limited.
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts(throttle_key(), 5)) {
            return;
        }


        $seconds = RateLimiter::availableIn(throttle_key());

        event(new Lockout($this, ceil($seconds / 60)));

        abort(Response::HTTP_TOO_MANY_REQUESTS, __('auth::messages.throttle', [
            'seconds' => $seconds,
            'minutes' => ceil($seconds / 60),
        ]));

    }
}
