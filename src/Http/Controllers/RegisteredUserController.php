<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\RegistrationRequest;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class RegisteredUserController extends Controller
{
    use ApiResponseTrait;

    /**
     * Handle an incoming registration request.
     */
    public function store(RegistrationRequest $request): JsonResponse
    {

        try {
            $user = Auth::user()->create($request->validated());

            event(new Registered($user));

            return $this->created('Registration Successful.');

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
