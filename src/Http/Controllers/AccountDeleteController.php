<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Http\Requests\AccountDeleteRequest;
use Illuminate\Routing\Controller;

class AccountDeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(AccountDeleteRequest $request): \Illuminate\Http\JsonResponse
    {
        return response()->success(__('auth::messages.account_deleted'));
    }
}
