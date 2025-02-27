<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Events\LoggedOut;
use Fintech\Auth\Exceptions\AccessForbiddenException;
use Fintech\Auth\Exceptions\AccountFrozenException;
use Fintech\Auth\Http\Requests\LoginRequest;
use Fintech\Auth\Http\Resources\LoginResource;
use Fintech\Auth\Traits\GuessAuthFieldTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
    use GuessAuthFieldTrait;

    /**
     * @lrd:start
     * Handle an incoming authentication request.
     *
     * @lrd:end
     */
    public function login(LoginRequest $request): LoginResource|JsonResponse
    {
        $request->ensureIsNotRateLimited();

        try {
            $credentials = $this->getAuthFieldFromInput($request);

            $passwordField = config('fintech.auth.password_field', 'password');

            $credentials[$passwordField] = $request->input($passwordField);

            $credentials['platform'] = $request->platform();

            $credentials['fcm_token'] = $request->input('fcm_token');

            $attemptUser = \Fintech\Auth\Facades\Auth::user()->login($credentials, 'sanctum');

            $request->clearRateLimited();

            return new LoginResource($attemptUser);

        } catch (AccessForbiddenException|AccountFrozenException $exception) {

            $request->hitRateLimited();

            return response()->forbidden($exception->getMessage());

        } catch (Exception $exception) {

            $request->hitRateLimited();

            return response()->failed($exception);
        }
    }

    /**
     * Destroy an authenticated session
     */
    public function logout(Request $request): JsonResponse
    {
        event(new LoggedOut($request->user()));

        $request->user('sanctum')->currentAccessToken()->delete();

        return response()->deleted(__('auth::messages.logout', ['app_name' => ucfirst(config('app.name'))]));
    }
}
