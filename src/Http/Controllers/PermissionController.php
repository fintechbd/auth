<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\ImportPermissionRequest;
use Fintech\Auth\Http\Requests\IndexPermissionRequest;
use Fintech\Auth\Http\Requests\StorePermissionRequest;
use Fintech\Auth\Http\Requests\UpdatePermissionRequest;
use Fintech\Auth\Http\Resources\PermissionCollection;
use Fintech\Auth\Http\Resources\PermissionResource;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class PermissionController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to permission
 *
 * @lrd:end
 */
class PermissionController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the permission resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     * @param IndexPermissionRequest $request
     * @return PermissionCollection|JsonResponse
     */
    public function index(IndexPermissionRequest $request): PermissionCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $permissionPaginate = Auth::permission()->list($inputs);

            return new PermissionCollection($permissionPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new permission resource in storage.
     *
     * @lrd:end
     * @param StorePermissionRequest $request
     * @return JsonResponse
     */
    public function store(StorePermissionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $permission = Auth::permission()->create($inputs);

            if (!$permission) {
                throw (new StoreOperationException())->setModel(config('fintech.auth.permission_model'));
            }

            return $this->created([
                'message' => __('core::messages.resource.created', ['model' => 'Permission']),
                'id' => $permission->getKey(),
            ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @LRDparam trashed boolean|nullable
     *
     * @lrd:start
     * Return a specified permission resource found by id.
     *
     * @lrd:end
     * @param int|string $id
     * @return PermissionResource|JsonResponse
     */
    public function show(string|int $id): PermissionResource|JsonResponse
    {
        try {

            $permission = Auth::permission()->find($id);

            if (!$permission) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.permission_model'), $id);
            }

            return new PermissionResource($permission);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified permission resource using id.
     *
     * @lrd:end
     */
    public function update(UpdatePermissionRequest $request, string|int $id): JsonResponse
    {
        try {

            $permission = Auth::permission()->find($id);

            if (!$permission) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.permission_model'), $id);
            }

            $inputs = $request->validated();

            if (!Auth::permission()->update($id, $inputs)) {

                throw (new UpdateOperationException())->setModel(config('fintech.auth.permission_model'), $id);
            }

            return $this->updated(__('core::messages.resource.updated', ['model' => 'Permission']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified permission resource using id.
     *
     * @lrd:end
     *
     * @return JsonResponse
     *
     * @throws ModelNotFoundException
     * @throws DeleteOperationException
     */
    public function destroy(string|int $id)
    {
        try {

            $permission = Auth::permission()->find($id);

            if (!$permission) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.permission_model'), $id);
            }

            if (!Auth::permission()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.auth.permission_model'), $id);
            }

            return $this->deleted(__('core::messages.resource.deleted', ['model' => 'Permission']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified permission resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $permission = Auth::permission()->find($id, true);

            if (!$permission) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.permission_model'), $id);
            }

            if (!Auth::permission()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.auth.permission_model'), $id);
            }

            return $this->restored(__('core::messages.resource.restored', ['model' => 'Permission']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the permission resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     * @param IndexPermissionRequest $request
     * @return JsonResponse
     */
    public function export(IndexPermissionRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $permissionPaginate = Auth::permission()->export($inputs);

            return $this->exported(__('core::messages.resource.exported', ['model' => 'Permission']));

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the permission resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     * @param ImportPermissionRequest $request
     * @return PermissionCollection|JsonResponse
     */
    public function import(ImportPermissionRequest $request): PermissionCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $permissionPaginate = Auth::permission()->list($inputs);

            return new PermissionCollection($permissionPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
