<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\ForgotPasswordRequest;
use Fintech\Auth\Http\Requests\PasswordResetRequest;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class PasswordResetController extends Controller
{
    use ApiResponseTrait;

    /**
     * Handle an incoming password reset link request.
     *
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(ForgotPasswordRequest $request): JsonResponse
    {
        $authField = config('fintech.auth.auth_field', 'login_id');

        $authFieldValue = $request->input($authField);

        $attemptUser = Auth::user()->list([$authField => $authFieldValue]);

        if ($attemptUser->isEmpty()) {
            return $this->failed(__('auth::messages.failed'));
        }

        $attemptUser = $attemptUser->first();

        if(Auth::otp()->create($authFieldValue)) {

        }

        return response()->json(['status' => __($status)]);

    }

    /**
     * Handle an incoming new password request.
     *
     * @throws ValidationException
     */
    public function update(PasswordResetRequest $request): JsonResponse
    {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
        }

        return response()->json(['status' => __($status)]);
    }
}
