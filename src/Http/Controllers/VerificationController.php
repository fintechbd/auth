<?php

namespace Fintech\Auth\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Fintech\Auth\Http\Requests\StoreVerificationRequest;
use Fintech\Auth\Http\Requests\UpdateVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VerificationController extends Controller
{
    /**
     *
     * @lrd:start
     * API let user to verify mobile, email and user account
     *  field value can only between **email|mobile|user**
     * send verification link or otp as per configuration
     * @lrd:end
     * @param StoreVerificationRequest $request
     * @return JsonResponse
     */
    public function store(StoreVerificationRequest $request): JsonResponse
    {

    }

    /**
     * Send a new email verification notification.
     * @param string $field
     * @param UpdateVerificationRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function update(string $field, UpdateVerificationRequest $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
