<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\ImportFavouriteRequest;
use Fintech\Auth\Http\Requests\IndexFavouriteRequest;
use Fintech\Auth\Http\Requests\StoreFavouriteRequest;
use Fintech\Auth\Http\Requests\UpdateFavouriteRequest;
use Fintech\Auth\Http\Resources\FavouriteCollection;
use Fintech\Auth\Http\Resources\FavouriteResource;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class FavouriteController
 * @package Fintech\Auth\Http\Controllers
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to Favourite
 * @lrd:end
 *
 */
class FavouriteController extends Controller
{
    use ApiResponseTrait;

    /**
     * @lrd:start
     * Return a listing of the *Favourite* resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     * @lrd:end
     *
     * @param IndexFavouriteRequest $request
     * @return FavouriteCollection|JsonResponse
     */
    public function index(IndexFavouriteRequest $request): FavouriteCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $favouritePaginate = Auth::favourite()->list($inputs);

            return new FavouriteCollection($favouritePaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new *Favourite* resource in storage.
     * @lrd:end
     *
     * @param StoreFavouriteRequest $request
     * @return JsonResponse
     * @throws StoreOperationException
     */
    public function store(StoreFavouriteRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $favourite = Auth::favourite()->create($inputs);

            if (!$favourite) {
                throw (new StoreOperationException())->setModel(config('fintech.auth.favourite_model'));
            }

            return $this->created([
                'message' => __('core::messages.resource.created', ['model' => 'Favourite']),
                'id' => $favourite->id
            ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified *Favourite* resource found by id.
     * @lrd:end
     *
     * @param string|int $id
     * @return FavouriteResource|JsonResponse
     * @throws ModelNotFoundException
     */
    public function show(string|int $id): FavouriteResource|JsonResponse
    {
        try {

            $favourite = Auth::favourite()->find($id);

            if (!$favourite) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.favourite_model'), $id);
            }

            return new FavouriteResource($favourite);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified *Favourite* resource using id.
     * @lrd:end
     *
     * @param UpdateFavouriteRequest $request
     * @param string|int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateFavouriteRequest $request, string|int $id): JsonResponse
    {
        try {

            $favourite = Auth::favourite()->find($id);

            if (!$favourite) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.favourite_model'), $id);
            }

            $inputs = $request->validated();

            if (!Auth::favourite()->update($id, $inputs)) {

                throw (new UpdateOperationException())->setModel(config('fintech.auth.favourite_model'), $id);
            }

            return $this->updated(__('core::messages.resource.updated', ['model' => 'Favourite']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified *Favourite* resource using id.
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     * @throws ModelNotFoundException
     * @throws DeleteOperationException
     */
    public function destroy(string|int $id)
    {
        try {

            $favourite = Auth::favourite()->find($id);

            if (!$favourite) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.favourite_model'), $id);
            }

            if (!Auth::favourite()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.auth.favourite_model'), $id);
            }

            return $this->deleted(__('core::messages.resource.deleted', ['model' => 'Favourite']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified *Favourite* resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     * @lrd:end
     *
     * @param string|int $id
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $favourite = Auth::favourite()->find($id, true);

            if (!$favourite) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.favourite_model'), $id);
            }

            if (!Auth::favourite()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.auth.favourite_model'), $id);
            }

            return $this->restored(__('core::messages.resource.restored', ['model' => 'Favourite']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Favourite* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param IndexFavouriteRequest $request
     * @return JsonResponse
     */
    public function export(IndexFavouriteRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $favouritePaginate = Auth::favourite()->export($inputs);

            return $this->exported(__('core::messages.resource.exported', ['model' => 'Favourite']));

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the *Favourite* resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @param ImportFavouriteRequest $request
     * @return FavouriteCollection|JsonResponse
     */
    public function import(ImportFavouriteRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $favouritePaginate = Auth::favourite()->list($inputs);

            return new FavouriteCollection($favouritePaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
