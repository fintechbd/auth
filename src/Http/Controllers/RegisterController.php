<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Events\Registered;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\RegistrationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class RegisterController extends Controller
{
    /**
     * Handle an incoming registration request.
     */
    public function __invoke(RegistrationRequest $request): JsonResponse
    {
        $userFields = config('fintech.auth.register_user_table_columns', [
            'name', 'mobile', 'email', 'login_id', 'password', 'pin',
            'language', 'currency', 'app_version', 'fcm_token', 'photo',
            'parent_id',
        ]);

        try {

            $userData = $request->only($userFields);

            $user = Auth::user()->create($userData);

            $profileData = $request->except($userFields);

            if (!empty($profileData)) {
                $profile = Auth::profile()->create($user->getKey(), $profileData);
            }

            event(new Registered($user));

            return response()->created('Registration Successful.');

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }
}
