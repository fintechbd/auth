<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Http\Requests\LoginRequest;
use Fintech\Auth\Models\User;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    use ApiResponseTrait;

    /**
     * Handle an incoming authentication request.
     *
     * @throws ValidationException
     */
    public function store(LoginRequest $request): JsonResponse
    {
        $request->ensureIsNotRateLimited();

        if (! Auth::attempt($request->only('login_id', 'password'))) {

            $request->hitRateLimited();

            return $this->failed(__('auth.failed'));
        }

        $request->clearRateLimited();

        /**
         * @var User $authUser
         */
        $authUser = Auth::user();

        $token = $authUser->createToken(config('app.name'))->plainTextToken;

        return response()->json(['data' => $authUser, 'token' => $token, 'message' => 'Login Successful.'], Response::HTTP_OK);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
