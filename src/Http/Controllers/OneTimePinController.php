<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\CreateOneTimePinRequest;
use Fintech\Auth\Http\Requests\VerifyOneTimePinRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use InvalidArgumentException;

class OneTimePinController extends Controller
{
    /**
     * @lrd:start
     * API let user verify using mobile, email and user account
     * field value can only between **email|mobile|user**
     * send verification link or otp as per configuration
     *
     * @lrd:end
     *
     * @throws Exception
     */
    public function request(CreateOneTimePinRequest $request): JsonResponse
    {
        $targetField = $request->has('mobile')
            ? 'mobile' :
            (
                $request->has('email')
                    ? 'email' :
                    ($request->has('user') ? 'user' : null)
            );

        $targetValue = $request->input($targetField);

        try {

            if (empty($targetValue)) {
                throw new InvalidArgumentException(__('auth::messages.verify.field_empty'));
            }

            $response = Auth::otp()->create($targetValue);

            if (! $response['status']) {
                throw new Exception($response['message']);
            }

            unset($response['status']);

            return response()->success($response);

        } catch (Exception $exception) {
            return response()->failed($exception);
        }
    }

    /**
     * Send a new email verification notification.
     */
    public function verify(VerifyOneTimePinRequest $request): JsonResponse
    {
        $token = $request->input('token');

        try {

            if (! Auth::otp()->exists($token)) {
                throw new Exception(__('auth::messages.verify.invalid'));
            }

            return response()->success(__('auth::messages.verify.success'));

        } catch (Exception $exception) {
            return response()->failed($exception);
        }
    }
}
