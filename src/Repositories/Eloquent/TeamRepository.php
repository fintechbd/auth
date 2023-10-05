<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\TeamRepository as InterfacesTeamRepository;
use Fintech\Auth\Models\Team;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/**
 * Class TeamRepository
 */
class TeamRepository extends EloquentRepository implements InterfacesTeamRepository
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
     * @return Paginator|Collection
     */
    public function list(array $filters = [])
    {
        $query = $this->model->newQuery();

        if (isset($filters['search']) && ! empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%")
                ->orWhereHas('roles', function (Builder $query) use ($filters) {
                    return $query->where('name', 'like', "%{$filters['search']}%");
                });
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['direction'] ?? 'asc');

        //Prepare Output
        return (isset($filters['paginate']) && $filters['paginate'] == true)
            ? $query->simplePaginate(($filters['per_page'] ?? 20))
            : $query->get();

    }
}
