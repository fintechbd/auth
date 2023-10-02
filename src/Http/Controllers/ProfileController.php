<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Http\Requests\ImportProfileRequest;
use Fintech\Auth\Http\Requests\IndexProfileRequest;
use Fintech\Auth\Http\Requests\StoreProfileRequest;
use Fintech\Auth\Http\Requests\UpdateProfileRequest;
use Fintech\Auth\Http\Resources\ProfileCollection;
use Fintech\Auth\Http\Resources\UserProfileResource;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\ResourceNotFoundException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class UserProfileController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to userProfile
 *
 * @lrd:end
 */
class ProfileController extends Controller
{
    use ApiResponseTrait;

    /**
     * UserProfileController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @lrd:start
     * Return a listing of the userProfile resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexProfileRequest $request): ProfileCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userProfilePaginate = \Auth::userProfile()->list($inputs);

            return new ProfileCollection($userProfilePaginate);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new userProfile resource in storage.
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreProfileRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userProfile = \Auth::userProfile()->create($inputs);

            if (! $userProfile) {
                throw new StoreOperationException();
            }

            return $this->created([
                'message' => __('core::messages.resource.created', ['model' => 'UserProfile']),
                'id' => $userProfile->id,
            ]);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified userProfile resource found by id.
     *
     * @lrd:end
     *
     * @throws ResourceNotFoundException
     */
    public function show(string|int $id): UserProfileResource|JsonResponse
    {
        try {

            $userProfile = \Auth::userProfile()->find($id);

            if (! $userProfile) {
                throw new ResourceNotFoundException(__('core::messages.resource.notfound', ['model' => 'UserProfile', 'id' => strval($id)]));
            }

            return new UserProfileResource($userProfile);

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified userProfile resource using id.
     *
     * @lrd:end
     *
     * @throws ResourceNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateProfileRequest $request, string|int $id): JsonResponse
    {
        try {

            $userProfile = \Auth::userProfile()->find($id);

            if (! $userProfile) {
                throw new ResourceNotFoundException(__('core::messages.resource.notfound', ['model' => 'UserProfile', 'id' => strval($id)]));
            }

            $inputs = $request->validated();

            if (! \Auth::userProfile()->update($id, $inputs)) {

                throw new UpdateOperationException();
            }

            return $this->updated(__('core::messages.resource.updated', ['model' => 'UserProfile']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified userProfile resource using id.
     *
     * @lrd:end
     *
     * @return JsonResponse
     *
     * @throws ResourceNotFoundException
     * @throws DeleteOperationException
     */
    public function destroy(string|int $id)
    {
        try {

            $userProfile = \Auth::userProfile()->find($id);

            if (! $userProfile) {
                throw new ResourceNotFoundException(__('core::messages.resource.notfound', ['model' => 'UserProfile', 'id' => strval($id)]));
            }

            if (! \Auth::userProfile()->destroy($id)) {

                throw new DeleteOperationException();
            }

            return $this->deleted(__('core::messages.resource.deleted', ['model' => 'UserProfile']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified userProfile resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $userProfile = \Auth::userProfile()->read($id, true);

            if (! $userProfile) {
                throw new ResourceNotFoundException(__('core::messages.resource.notfound', ['model' => 'UserProfile', 'id' => strval($id)]));
            }

            if (! \Auth::userProfile()->restore($id)) {

                throw new RestoreOperationException();
            }

            return $this->restored(__('core::messages.resource.restored', ['model' => 'UserProfile']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the userProfile resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexProfileRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userProfilePaginate = \Auth::userProfile()->export($inputs);

            return $this->exported(__('core::messages.resource.exported', ['model' => 'UserProfile']));

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the userProfile resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @return ProfileCollection|JsonResponse
     */
    public function import(ImportProfileRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $userProfilePaginate = \Auth::userProfile()->list($inputs);

            return new ProfileCollection($userProfilePaginate);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
