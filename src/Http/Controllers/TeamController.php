<?php

namespace Fintech\Auth\Http\Controllers;

use Fintech\Auth\Http\Requests\ImportTeamRequest;
use Fintech\Auth\Http\Requests\IndexTeamRequest;
use Fintech\Auth\Http\Requests\StoreTeamRequest;
use Fintech\Auth\Http\Requests\UpdateTeamRequest;
use Fintech\Auth\Http\Resources\TeamCollection;
use Fintech\Auth\Http\Resources\TeamResource;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\ResourceNotFoundException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Class TeamController
 *
 * @lrd:start
 * This class handle create, display, update, delete & restore
 * operation related to team
 *
 * @lrd:end
 */
class TeamController extends Controller
{
    use ApiResponseTrait;

    /**
     * TeamController constructor.
     */
    public function __construct()
    {

    }

    /**
     * @lrd:start
     * Return a listing of the team resource as collection.
     *
     * ** ```paginate=false``` returns all resource as list not pagination **
     *
     * @lrd:end
     */
    public function index(IndexTeamRequest $request): TeamCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $teamPaginate = \Auth::team()->list($inputs);

            return new TeamCollection($teamPaginate);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a new team resource in storage.
     *
     * @lrd:end
     *
     * @throws StoreOperationException
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $team = \Auth::team()->create($inputs);

            if (! $team) {
                throw new StoreOperationException();
            }

            return $this->created([
                'message' => __('auth::messages.resource.created', ['model' => 'Team']),
                'id' => $team->id,
            ]);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified team resource found by id.
     *
     * @lrd:end
     *
     * @throws ResourceNotFoundException
     */
    public function show(string|int $id): TeamResource|JsonResponse
    {
        try {

            $team = \Auth::team()->read($id);

            if (! $team) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'Team', 'id' => strval($id)]));
            }

            return new TeamResource($team);

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified team resource using id.
     *
     * @lrd:end
     *
     * @throws ResourceNotFoundException
     * @throws UpdateOperationException
     */
    public function update(UpdateTeamRequest $request, string|int $id): JsonResponse
    {
        try {

            $team = \Auth::team()->read($id);

            if (! $team) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'Team', 'id' => strval($id)]));
            }

            $inputs = $request->validated();

            if (! \Auth::team()->update($id, $inputs)) {

                throw new UpdateOperationException();
            }

            return $this->updated(__('auth::messages.resource.updated', ['model' => 'Team']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified team resource using id.
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

            $team = \Auth::team()->read($id);

            if (! $team) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'Team', 'id' => strval($id)]));
            }

            if (! \Auth::team()->destroy($id)) {

                throw new DeleteOperationException();
            }

            return $this->deleted(__('auth::messages.resource.deleted', ['model' => 'Team']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Restore the specified team resource from trash.
     * ** ```Soft Delete``` needs to enabled to use this feature**
     *
     * @lrd:end
     *
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $team = \Auth::team()->read($id, true);

            if (! $team) {
                throw new ResourceNotFoundException(__('auth::messages.resource.notfound', ['model' => 'Team', 'id' => strval($id)]));
            }

            if (! \Auth::team()->restore($id)) {

                throw new RestoreOperationException();
            }

            return $this->restored(__('auth::messages.resource.restored', ['model' => 'Team']));

        } catch (ResourceNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the team resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     */
    public function export(IndexTeamRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $teamPaginate = \Auth::team()->export($inputs);

            return $this->exported(__('auth::messages.resource.exported', ['model' => 'Team']));

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the team resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     *
     * @return TeamCollection|JsonResponse
     */
    public function import(ImportTeamRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $teamPaginate = \Auth::team()->list($inputs);

            return new TeamCollection($teamPaginate);

        } catch (\Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }
}
