<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Facades\Auth;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Exceptions\ResourceNotFoundException;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Fintech\Auth\Http\Resources\UserResource;
use Fintech\Auth\Http\Resources\UserCollection;
use Fintech\Auth\Http\Requests\ImportUserRequest;
use Fintech\Auth\Http\Requests\StoreUserRequest;
use Fintech\Auth\Http\Requests\UpdateUserRequest;
use Fintech\Auth\Http\Requests\IndexUserRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class UserController
 * @package Fintech\Auth\Http\Controllers
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to user
 * @lrd:end
 *
 */

class UserController extends Controller
{
    use ApiResponseTrait;

    /**
     * UserController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @lrd:start
     * Return a listing of the user resource as collection.
     *
     * ** ```paginate=false``` returns all resource as list not pagination **
     * @lrd:end
     *
     * @param IndexUserRequest $request
     * @return UserCollection|JsonResponse
     */
    public function index(IndexUserRequest $request): UserCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userPaginate = Auth::user()->list($inputs);

            return new UserCollection($userPaginate);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new user resource in storage.
     * @lrd:end
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     * @throws StoreOperationException
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $user = Auth::user()->create($inputs);

            if (!$user) {
                throw new StoreOperationException();
            }

            return $this->created([
                'message' => __('auth::messages.resource.created', ['model' => 'User']),
                'id' => $user->id
             ]);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified user resource found by id.
     * @lrd:end
     *
     * @param string|int $id
     * @return UserResource|JsonResponse
     * @throws ResourceNotFoundException
     */
    public function show(string|int $id): UserResource|JsonResponse
    {
        try {

            $user = Auth::user()->read($id);

            if (!$user) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'User', 'id' => strval($id)]));
            }

            return new UserResource($user);

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified user resource using id.
     * @lrd:end
     *
     * @param UpdateUserRequest $request
     * @param string|int $id
     * @return JsonResponse
     * @throws ResourceNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateUserRequest $request, string|int $id): JsonResponse
    {
        try {

            $user = Auth::user()->read($id);

            if (!$user) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'User', 'id' => strval($id)]));
            }

            $inputs = $request->validated();

            if (!Auth::user()->update($id, $inputs)) {

                throw new UpdateOperationException();
            }

            return $this->updated(__('auth::messages.resource.updated', ['model' => 'User']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified user resource using id.
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

            $user = Auth::user()->read($id);

            if (!$user) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'User', 'id' => strval($id)]));
            }

            if (!Auth::user()->destroy($id)) {

                throw new DeleteOperationException();
            }

            return $this->deleted(__('auth::messages.resource.deleted', ['model' => 'User']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified user resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $user = Auth::user()->read($id, true);

            if (!$user) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'User', 'id' => strval($id)]));
            }

            if (!Auth::user()->restore($id)) {

                throw new RestoreOperationException();
            }

            return $this->restored(__('auth::messages.resource.restored', ['model' => 'User']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the user resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param IndexUserRequest $request
     * @return JsonResponse
     */
    public function export(IndexUserRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userPaginate = Auth::user()->export($inputs);

            return $this->exported(__('auth::messages.resource.exported', ['model' => 'User']));

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the user resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param ImportUserRequest $request
     * @return UserCollection|JsonResponse
     */
    public function import(ImportUserRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userPaginate = Auth::user()->list($inputs);

            return new UserCollection($userPaginate);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
