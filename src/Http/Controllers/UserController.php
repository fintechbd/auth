<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Enums\PasswordResetOption;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\ImportUserRequest;
use Fintech\Auth\Http\Requests\IndexUserRequest;
use Fintech\Auth\Http\Requests\StoreUserRequest;
use Fintech\Auth\Http\Requests\UpdateUserRequest;
use Fintech\Auth\Http\Requests\UserAuthResetRequest;
use Fintech\Auth\Http\Resources\UserCollection;
use Fintech\Auth\Http\Resources\UserResource;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class UserController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to user
 *
 * @lrd:end
 */
class UserController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the user resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexUserRequest $request): UserCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userPaginate = Auth::user()->list($inputs);

            return new UserCollection($userPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     *
     * @lrd:start
     * Create a new user resource in storage.
     *
     * @lrd:end
     * @param StoreUserRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();


            $user = Auth::user()->create($inputs);

            if (!$user) {
                throw (new StoreOperationException())->setModel(config('fintech.auth.user_model'));
            }

            return $this->created([
                'message' => __('core::messages.resource.created', ['model' => 'User']),
                'id' => $user->id,
            ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @LRDparam trashed boolean|nullable
     *
     * @lrd:start
     * Return a specified user resource found by id.
     *
     * @lrd:end
     *
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): UserResource|JsonResponse
    {
        try {

            $user = Auth::user()->find($id);

            if (!$user) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.user_model'), $id);
            }

            return new UserResource($user);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified user resource using id.
     *
     * @lrd:end
     *
     * @throws UpdateOperationException
     */
    public function update(UpdateUserRequest $request, string|int $id): JsonResponse
    {
        try {

            $user = Auth::user()->find($id);

            if (!$user) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.user_model'), $id);
            }

            $inputs = $request->validated();

            if (!Auth::user()->update($id, $inputs)) {

                throw (new UpdateOperationException())->setModel(config('fintech.auth.user_model'), $id);
            }

            return $this->updated(__('core::messages.resource.updated', ['model' => 'User']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified user resource using id.
     *
     * @lrd:end
     *
     * @return JsonResponse
     *
     * @throws DeleteOperationException
     */
    public function destroy(string|int $id)
    {
        try {

            $user = Auth::user()->find($id);

            if (!$user) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.user_model'), $id);
            }

            if (!Auth::user()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.auth.user_model'), $id);
            }

            return $this->deleted(__('core::messages.resource.deleted', ['model' => 'User']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified user resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $user = Auth::user()->find($id, true);

            if (!$user) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.user_model'), $id);
            }

            if (!Auth::user()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.auth.user_model'), $id);
            }

            return $this->restored(__('core::messages.resource.restored', ['model' => 'User']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the user resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexUserRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userPaginate = Auth::user()->export($inputs);

            return $this->exported(__('core::messages.resource.exported', ['model' => 'User']));

        } catch (Exception $exception) {

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
     * @return UserCollection|JsonResponse
     */
    public function import(ImportUserRequest $request): UserCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userPaginate = Auth::user()->list($inputs);

            return new UserCollection($userPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Reset user pin, password or both from admin panel
     * and send an updated value to targeted user
     * system will also verify which user is requesting
     * @lrd:end
     *
     * @param int|string $id
     * @param UserAuthResetRequest $request
     * @return JsonResponse
     */
    public function reset(string|int $id, string $field, UserAuthResetRequest $request): JsonResponse
    {

        $requestUser = $request->user();

        try {

            $user = Auth::user()->find($id);

            if (!$user) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.user_model'), $id);
            }

            $response = Auth::user()->reset($user, $field);

            if (!$response['status']) {
                throw new Exception($response['response']);
            }

            return $this->success($response['message']);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
