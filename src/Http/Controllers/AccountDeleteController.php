<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Events\AccountDeleted;
use Fintech\Auth\Events\AccountDeletedAccepted;
use Fintech\Auth\Events\AccountDeletedRequested;
use Fintech\Auth\Http\Requests\AccountDeleteRequest;
use Illuminate\Routing\Controller;

class AccountDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AccountDeleteRequest $request): \Illuminate\Http\JsonResponse
    {
        event(new AccountDeletedRequested($request));
        event(new AccountDeletedAccepted($request));
        event(new AccountDeleted($request));

        return response()->success(__('auth::messages.account_deleted'));
    }
}
