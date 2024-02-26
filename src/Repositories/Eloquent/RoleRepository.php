<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\RoleRepository as InterfacesRoleRepository;
use Fintech\Auth\Models\Role;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

/**
 * Class RoleRepository
 */
class RoleRepository extends EloquentRepository implements InterfacesRoleRepository
{
    public function __construct()
    {
        parent::__construct(config('fintech.auth.role_model', Role::class));

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

        if (!empty($filters['search'])) {
            if (is_numeric($filters['search'])) {
                $query->where($this->model->getKeyName(), 'like', "%{$filters['search']}%");
            } else {
                $query->where('name', 'like', "%{$filters['search']}%")
                    ->orWhereHas('permissions', function (Builder $query) use ($filters) {
                        return $query->where('name', 'like', "%{$filters['search']}%");
                    });
            }
        }

        if (!empty($filters['team_id'])) {
            $query->where('team_id', '=', $filters['team_id']);
        }

        if (!empty($filters['id_not_in_array']) && is_array($filters['id_not_in_array'])) {
            $query->whereNotIn('id', $filters['id_not_in_array']);
        }

        if (!empty($filters['name'])) {
            $query->where('name', '=', $filters['name']);
        }

        //Display Trashed
        if (isset($filters['trashed']) && $filters['trashed'] === true) {
            $query->onlyTrashed();
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
