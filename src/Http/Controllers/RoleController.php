<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Exceptions\ResourceNotFoundException;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Fintech\Auth\Http\Resources\RoleResource;
use Fintech\Auth\Http\Resources\RoleCollection;
use Fintech\Auth\Http\Requests\ImportRoleRequest;
use Fintech\Auth\Http\Requests\StoreRoleRequest;
use Fintech\Auth\Http\Requests\UpdateRoleRequest;
use Fintech\Auth\Http\Requests\IndexRoleRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class RoleController
 * @package Fintech\Auth\Http\Controllers
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to role
 * @lrd:end
 *
 */

class RoleController extends Controller
{
    use ApiResponseTrait;

    /**
     * RoleController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @lrd:start
     * Return a listing of the role resource as collection.
     *
     * ** ```paginate=false``` returns all resource as list not pagination **
     * @lrd:end
     *
     * @param IndexRoleRequest $request
     * @return RoleCollection|JsonResponse
     */
    public function index(IndexRoleRequest $request): RoleCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $rolePaginate = \Auth::role()->list($inputs);

            return new RoleCollection($rolePaginate);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new role resource in storage.
     * @lrd:end
     *
     * @param StoreRoleRequest $request
     * @return JsonResponse
     * @throws StoreOperationException
     */
    public function store(StoreRoleRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $role = \Auth::role()->create($inputs);

            if (!$role) {
                throw new StoreOperationException();
            }

            return $this->created([
                'message' => __('auth::messages.resource.created', ['model' => 'Role']),
                'id' => $role->id
             ]);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified role resource found by id.
     * @lrd:end
     *
     * @param string|int $id
     * @return RoleResource|JsonResponse
     * @throws ResourceNotFoundException
     */
    public function show(string|int $id): RoleResource|JsonResponse
    {
        try {

            $role = \Auth::role()->read($id);

            if (!$role) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'Role', 'id' => strval($id)]));
            }

            return new RoleResource($role);

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified role resource using id.
     * @lrd:end
     *
     * @param UpdateRoleRequest $request
     * @param string|int $id
     * @return JsonResponse
     * @throws ResourceNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateRoleRequest $request, string|int $id): JsonResponse
    {
        try {

            $role = \Auth::role()->read($id);

            if (!$role) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'Role', 'id' => strval($id)]));
            }

            $inputs = $request->validated();

            if (!\Auth::role()->update($id, $inputs)) {

                throw new UpdateOperationException();
            }

            return $this->updated(__('auth::messages.resource.updated', ['model' => 'Role']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified role resource using id.
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     * @throws ResourceNotFoundException
     * @throws DeleteOperationException
     */
    public function destroy(string|int $id)
    {
        try {

            $role = \Auth::role()->read($id);

            if (!$role) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'Role', 'id' => strval($id)]));
            }

            if (!\Auth::role()->destroy($id)) {

                throw new DeleteOperationException();
            }

            return $this->deleted(__('auth::messages.resource.deleted', ['model' => 'Role']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified role resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $role = \Auth::role()->read($id, true);

            if (!$role) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'Role', 'id' => strval($id)]));
            }

            if (!\Auth::role()->restore($id)) {

                throw new RestoreOperationException();
            }

            return $this->restored(__('auth::messages.resource.restored', ['model' => 'Role']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the role resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param IndexRoleRequest $request
     * @return JsonResponse
     */
    public function export(IndexRoleRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $rolePaginate = \Auth::role()->export($inputs);

            return $this->exported(__('auth::messages.resource.exported', ['model' => 'Role']));

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the role resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param ImportRoleRequest $request
     * @return RoleCollection|JsonResponse
     */
    public function import(ImportRoleRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $rolePaginate = \Auth::role()->list($inputs);

            return new RoleCollection($rolePaginate);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
