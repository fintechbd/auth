<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\RolePermissionRequest;
use Fintech\Auth\Http\Resources\RolePermissionResource;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

class RolePermissionController extends Controller
{
    use ApiResponseTrait;

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

            if (!$role) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.role_model'), $id);
            }

            return new RolePermissionResource($role);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
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

            if (!$role) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.role_model'), $id);
            }

            $inputs = $request->validated();

            if (!Auth::role()->update($id, $inputs)) {

                throw (new UpdateOperationException())->setModel(config('fintech.auth.role_model'), $id);
            }

            return $this->updated(__('auth::messages.role.permission_assigned', ['role' => strtolower($role->name ?? 'N/A')]));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
