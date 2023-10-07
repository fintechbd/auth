<?php

namespace Fintech\Auth\Repositories\Mongodb;

use Fintech\Auth\Interfaces\TeamRepository as InterfacesTeamRepository;
use Fintech\Auth\Models\Team;
use Fintech\Core\Repositories\MongodbRepository;
use Illuminate\Contracts\Pagination\Paginator;
use InvalidArgumentException;

/**
 * Class TeamRepository
 */
class TeamRepository extends MongodbRepository implements InterfacesTeamRepository
{
    public function __construct()
    {
        $model = app()->make(config('fintech.auth.team_model', Team::class));

        if (! $model instanceof Model) {
            throw new InvalidArgumentException("Eloquent repository require model class to be `Illuminate\Database\Eloquent\Model` instance.");
        }

        $this->model = $model;
    }

    /**
     * return a list or pagination of items from
     * filtered options
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function list(array $filters = [])
    {
        $query = $this->model->newQuery();

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['direction'] ?? 'asc');

        //Prepare Output
        return (isset($filters['paginate']) && $filters['paginate'] == true)
            ? $query->paginate(($filters['per_page'] ?? 20))
            : $query->get();

    }
}
