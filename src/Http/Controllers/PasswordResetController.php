<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\ForgotPasswordRequest;
use Fintech\Auth\Http\Requests\PasswordResetRequest;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class PasswordResetController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * This api receive `login_id` as unique user then as per configuration
     * and send temporary password or reset link or One Time Pin verifcation
     * to proceed
     * @lrd:end
     * @param ForgotPasswordRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function store(ForgotPasswordRequest $request): JsonResponse
    {
        try {

            $authField = config('fintech.auth.auth_field', 'login_id');

            $authFieldValue = $request->input($authField);

            $attemptUser = Auth::user()->list([$authField => $authFieldValue]);

            if ($attemptUser->isEmpty()) {
                return $this->failed(__('auth::messages.failed'));
            }

            $response = Auth::passwordReset()->notifyUser($attemptUser->first());

            if (!$response['status']) {
                throw new \Exception($response['message']);
            }

            return $this->success($response['message']);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @LRDparam password_confirmation string|required|min:8
     * @lrd:start
     * This api receive `token`, `password` & `password_confirmation` to reset
     * user with given password. If otp or token didn't match throws exception
     * to proceed
     * @lrd:end
     * @param PasswordResetRequest $request
     * @return JsonResponse
     */
    public function update(PasswordResetRequest $request): JsonResponse
    {
        $passwordField = config('fintech.auth.password_field', 'password');

        $token = $request->input('token');

        $password = $request->input($passwordField);

        try {

            $activeToken = Auth::passwordReset()->verifyToken($token);

            $targetedUser = Auth::user()->list([config('fintech.auth.auth_field', 'login_id'), $activeToken->email]);

            if ($targetedUser->isEmpty()) {
                throw new \ErrorException(__('auth::messages.reset.user_not_found'));
            }

            $targetedUser = $targetedUser->first();

            if (!Auth::user()->update($targetedUser->getKey(), [$passwordField => $password])) {
                throw (new UpdateOperationException())->setModel(config('fintech.auth.user_model'), $targetedUser->getKey());
            }

            return $this->updated(__('auth::messages.reset.success'));

        } catch (\Exception $exception) {
            return $this->failed($exception->getMessage());
        }
    }
}
