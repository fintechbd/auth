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
     * @throws ValidationException
     */
    public function store(ForgotPasswordRequest $request): JsonResponse
    {
        $authField = config('fintech.auth.auth_field', 'login_id');

        $attemptUser = Auth::user()->list([$authField => $request->input($authField), 'paginate' => false]);

        if ($attemptUser->isEmpty()) {
            return $this->failed(__('auth::messages.failed'));
        }

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            throw ValidationException::withMessages([
                'email' => [__($status)],
            ]);
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
