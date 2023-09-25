<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Http\Requests\RegistrationRequest;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     */
    public function store(RegistrationRequest $request): Response
    {

        \Fintech\Auth\Facades\Auth::user()->create($request->validated());

        //        event(new Registered($user));
        //
        //        Auth::login($user);

        return response()->noContent();
    }
}
