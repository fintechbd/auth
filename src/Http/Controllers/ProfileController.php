<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\UserProfileUpdateRequest;
use Fintech\Auth\Http\Resources\UserFullProfileResource;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\RestApi\UserRequestFieldTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProfileController extends Controller
{
    use UserRequestFieldTrait;

    /**
     * Handle the incoming request.
     */
    public function show(Request $request): UserFullProfileResource|JsonResponse
    {
        try {

            $user = $request->user('sanctum');

            return new UserFullProfileResource($user);

        } catch (Exception $exception) {
            return response()->failed($exception);
        }
    }

    /**
     * Handle the incoming request.
     *
     * @throws UpdateOperationException|\ErrorException
     */
    public function update(UserProfileUpdateRequest $request): JsonResponse
    {
        try {

            $user = $request->user('sanctum');

            if (! Auth::user()->update($user->getKey(), $request->only($this->userFields))) {

                throw (new UpdateOperationException())->setModel(config('fintech.auth.user_model'), $user->getKey());
            }

            if ($request->except($this->userFields) != []) {
                if (! Auth::profile()->update($user->getKey(), $request->except($this->userFields))) {

                    throw (new UpdateOperationException())->setModel(config('fintech.auth.user_model'), $user->getKey());
                }
            }

            return response()->updated(
                __('auth::messages.user_profile_update', [
                    'fields' => collect($request->validated())->keys()->map(fn ($field) => ucfirst($field))->join(', '),
                ])
            );

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }
}
