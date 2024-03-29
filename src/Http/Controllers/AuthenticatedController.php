<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Events\LoggedIn;
use Fintech\Auth\Events\LoggedOut;
use Fintech\Auth\Http\Requests\LoginRequest;
use Fintech\Auth\Http\Resources\LoginResource;
use Fintech\Auth\Traits\GuessAuthFieldTrait;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Class AuthenticatedSessionController
 *
 * @lrd:start
 * This class handle login and logout of a user from
 * admin, frontend and mobile application
 *
 * @lrd:end
 */
class AuthenticatedController extends Controller
{
    use ApiResponseTrait;
    use GuessAuthFieldTrait;

    /**
     * @lrd:start
     * Handle an incoming authentication request.
     * @lrd:end
     *
     * @param LoginRequest $request
     * @return LoginResource|JsonResponse
     * @throws ValidationException
     */
    public function login(LoginRequest $request): LoginResource|JsonResponse
    {
        $request->ensureIsNotRateLimited();

        try {
            $credentials = $this->getAuthFieldFromInput($request);

            $passwordField = config('fintech.auth.password_field', 'password');
            $credentials[$passwordField] = $request->input($passwordField);

            $attemptUser = \Fintech\Auth\Facades\Auth::user()->login($credentials, 'web');


            if (!$attemptUser->can('auth.login')) {

                Auth::guard('web')->logout();

                return $this->forbidden(__('auth::messages.forbidden', ['permission' => permission_format('auth.login', 'auth')]));
            }

            $request->clearRateLimited();

            event(new LoggedIn($attemptUser));

            return new LoginResource($attemptUser);

        } catch (Exception $exception) {

            $request->hitRateLimited();

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * Destroy an authenticated session
     */
    public function logout(Request $request): JsonResponse
    {
        event(new LoggedOut($request->user()));

        Auth::guard('web')->logout();

        return $this->deleted(__('auth::messages.logout'));
    }
}
