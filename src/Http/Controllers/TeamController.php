<?php

namespace Fintech\Auth\Http\Controllers;

use Exception;
use Fintech\Auth\Facades\Auth;
use Fintech\Auth\Http\Requests\ImportTeamRequest;
use Fintech\Auth\Http\Requests\IndexTeamRequest;
use Fintech\Auth\Http\Requests\StoreTeamRequest;
use Fintech\Auth\Http\Requests\UpdateTeamRequest;
use Fintech\Auth\Http\Resources\TeamCollection;
use Fintech\Auth\Http\Resources\TeamResource;
use Fintech\Core\Exceptions\DeleteOperationException;
use Fintech\Core\Exceptions\RestoreOperationException;
use Fintech\Core\Exceptions\StoreOperationException;
use Fintech\Core\Exceptions\UpdateOperationException;
use Fintech\Core\Http\Requests\DropDownRequest;
use Fintech\Core\Http\Resources\DropDownCollection;
use Fintech\Core\Traits\ApiResponseTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @lrd:start
     * Return a listing of the team resource as collection.
     *
     * *```paginate=false``` returns all resource as list not pagination*
     *
     * @lrd:end
     */
    public function index(IndexTeamRequest $request): TeamCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $teamPaginate = Auth::team()->list($inputs);

            return new TeamCollection($teamPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @LRDparam trashed boolean|nullable
     *
     * @lrd:start
     * Create a new team resource in storage.
     *
     * @lrd:end
     * @param StoreTeamRequest $request
     * @return JsonResponse
     */
    public function store(StoreTeamRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $team = Auth::team()->create($inputs);

            if (!$team) {
                throw (new StoreOperationException())->setModel(config('fintech.auth.team_model'));
            }

            return $this->created([
                'message' => __('core::messages.resource.created', ['model' => 'Team']),
                'id' => $team->getKey(),
            ]);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Return a specified team resource found by id.
     *
     * @lrd:end
     * @param int|string $id
     * @return TeamResource|JsonResponse
     */
    public function show(string|int $id): TeamResource|JsonResponse
    {
        try {

            $team = Auth::team()->find($id);

            if (!$team) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.team_model'), $id);
            }

            return new TeamResource($team);

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Update a specified team resource using id.
     *
     * @lrd:end
     * @param UpdateTeamRequest $request
     * @param int|string $id
     * @return JsonResponse
     */
    public function update(UpdateTeamRequest $request, string|int $id): JsonResponse
    {
        try {

            $team = Auth::team()->find($id);

            if (!$team) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.team_model'), $id);
            }

            $inputs = $request->validated();

            if (!Auth::team()->update($id, $inputs)) {

                throw (new UpdateOperationException())->setModel(config('fintech.auth.team_model'), $id);
            }

            return $this->updated(__('core::messages.resource.updated', ['model' => 'Team']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Soft delete a specified team resource using id.
     *
     * @lrd:end
     *
     * @param int|string $id
     * @return JsonResponse
     */
    public function destroy(string|int $id)
    {
        try {

            $team = Auth::team()->find($id);

            if (!$team) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.team_model'), $id);
            }

            if (!Auth::team()->destroy($id)) {

                throw (new DeleteOperationException())->setModel(config('fintech.auth.team_model'), $id);
            }

            return $this->deleted(__('core::messages.resource.deleted', ['model' => 'Team']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

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
     * @param int|string $id
     * @return JsonResponse
     */
    public function restore(string|int $id)
    {
        try {

            $team = Auth::team()->find($id, true);

            if (!$team) {
                throw (new ModelNotFoundException())->setModel(config('fintech.auth.team_model'), $id);
            }

            if (!Auth::team()->restore($id)) {

                throw (new RestoreOperationException())->setModel(config('fintech.auth.team_model'), $id);
            }

            return $this->restored(__('core::messages.resource.restored', ['model' => 'Team']));

        } catch (ModelNotFoundException $exception) {

            return $this->notfound($exception->getMessage());

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @lrd:start
     * Create a exportable list of the team resource as document.
     * After export job is done system will fire  export completed event
     *
     * @lrd:end
     * @param IndexTeamRequest $request
     * @return JsonResponse
     */
    public function export(IndexTeamRequest $request): JsonResponse
    {
        try {
            $inputs = $request->validated();

            $teamPaginate = Auth::team()->export($inputs);

            return $this->exported(__('core::messages.resource.exported', ['model' => 'Team']));

        } catch (Exception $exception) {

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
     * @param ImportTeamRequest $request
     * @return TeamCollection|JsonResponse
     */
    public function import(ImportTeamRequest $request): TeamCollection|JsonResponse
    {
        try {
            $inputs = $request->validated();

            $teamPaginate = Auth::team()->list($inputs);

            return new TeamCollection($teamPaginate);

        } catch (Exception $exception) {

            return $this->failed($exception->getMessage());
        }
    }

    /**
     * @param DropDownRequest $request
     * @return DropDownCollection|JsonResponse
     */
    public function dropdown(DropDownRequest $request): DropDownCollection|JsonResponse
    {
        try {
            $filters = $request->all();

            $label = 'name';

            $attribute = 'id';

            if (!empty($filters['label'])) {
                $label = $filters['label'];
                unset($filters['label']);
            }

            if (!empty($filters['attribute'])) {
                $attribute = $filters['attribute'];
                unset($filters['attribute']);
            }

            $entries = Auth::team()->list($filters)->map(function ($entry) use ($label, $attribute) {
                return [
                    'label' => $entry->{$label} ?? 'name',
                    'attribute' => $entry->{$attribute} ?? 'id'
                ];
            });

            return new DropDownCollection($entries);

        } catch (Exception $exception) {
            return $this->failed($exception->getMessage());
        }
    }
}
