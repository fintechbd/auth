<?php

namespace Fintech\Auth\Http\Controllers;

use App\Providers\RouteServiceProvider;
use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\StoreVerificationRequest;
use Fintech\Auth\Http\Requests\UpdateVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;

class VerificationController extends Controller
{
    /**
     *
     * @lrd:start
     * API let user to verify mobile, email and user account
     * field value can only between **email|mobile|user**
     * send verification link or otp as per configuration
     * @lrd:end
     * @param StoreVerificationRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function store(StoreVerificationRequest $request): JsonResponse
    {
        Auth::otp()->create();

        return response()->json($request->all());
    }

    /**
     * Send a new email verification notification.
     * @param UpdateVerificationRequest $request
     * @return JsonResponse|RedirectResponse
     */
    public function update(UpdateVerificationRequest $request): JsonResponse|RedirectResponse
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->intended(RouteServiceProvider::HOME);
        }

        $request->user()->sendEmailVerificationNotification();

        return response()->json(['status' => 'verification-link-sent']);
    }
}
