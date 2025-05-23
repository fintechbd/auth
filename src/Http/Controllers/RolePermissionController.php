<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\RolePermissionRequest;
use Fintech\Auth\Http\Resources\RolePermissionResource;
use Fintech\Core\Exceptions\UpdateOperationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class RolePermissionController extends Controller
{
    /**
     * @lrd:start
     * return permissions to a specified role resource using id.
     *
     * @lrd:end
     */
    public function show(string|int $id): RolePermissionResource|JsonResponse
    {
        try {

            $role = Auth::role()->find($id);

            if (! $role) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.role_model'), $id);
            }

            return new RolePermissionResource($role);

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }

    /**
     * @lrd:start
     * Assign permissions to a specified role resource using id.
     *
     * @lrd:end
     */
    public function update(RolePermissionRequest $request, string|int $id): JsonResponse
    {
        try {

            $role = Auth::role()->find($id);

            if (! $role) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.role_model'), $id);
            }

            $inputs = $request->validated();

            if (! Auth::role()->update($id, $inputs)) {

                throw (new UpdateOperationException())->setModel(config('fintech.auth.role_model'), $id);
            }

            return response()->updated(__('auth::messages.role.permission_assigned', ['role' => strtolower($role->name ?? 'N/A')]));

        } catch (Exception $exception) {

            return response()->failed($exception);
        }
    }
}
