<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\CreateOneTimePinRequest;
use Fintech\Auth\Http\Requests\VerifyOneTimePinRequest;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class OneTimePinController extends Controller
{
    use ApiResponseTrait;

    /**
     *
     * @lrd:start
     * API let user to verify mobile, email and user account
     * field value can only between **email|mobile|user**
     * send verification link or otp as per configuration
     * @lrd:end
     * @param CreateOneTimePinRequest $request
     * @return JsonResponse
     * @throws \Exception
     */
    public function request(CreateOneTimePinRequest $request): JsonResponse
    {
        $targetField = $request->input('mobile');

        try {
            $response = Auth::otp()->create($targetField);

            if (!$response['status']) {
                throw new \Exception($response['message']);
            }

            return $this->success($response['message']);

        } catch (\Exception $exception) {
            return $this->failed($exception->getMessage());
        }
    }

    /**
     * Send a new email verification notification.
     * @param VerifyOneTimePinRequest $request
     * @return JsonResponse
     */
    public function verify(VerifyOneTimePinRequest $request): JsonResponse
    {
        $token = $request->input('token');

        try {

            if (!Auth::otp()->exists($token)) {
                throw new \Exception(__('auth::messages.verify.invalid'));
            }

            return $this->success(__('auth::messages.verify.success'));

        } catch (\Exception $exception) {
            return $this->failed($exception->getMessage());
        }
    }
}
