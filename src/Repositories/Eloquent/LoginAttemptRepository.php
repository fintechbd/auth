<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Core\Repositories\EloquentRepository;
use Fintech\Auth\Interfaces\LoginAttemptRepository as InterfacesLoginAttemptRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LoginAttemptRepository
 * @package Fintech\Auth\Repositories\Eloquent
 */
class LoginAttemptRepository extends EloquentRepository implements InterfacesLoginAttemptRepository
{
    public function __construct()
    {
        parent::__construct(config('fintech.auth.login_attempt_model', \Fintech\Auth\Models\LoginAttempt::class));
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

        //Searching
        if (!empty($filters['search'])) {
            $query->whereHas('user', function ($query) use ($filters) {
                return $query->where('name', 'like', "%{$filters['search']}%");
            });
            $query->orWhere($this->model->getKeyName(), 'like', "%{$filters['search']}%");
            $query->orWhere('ip', 'like', "%{$filters['search']}%");
            $query->orWhere('mac', 'like', "%{$filters['search']}%");
            $query->orWhere('platform', 'like', "%{$filters['search']}%");
            $query->orWhere('agent', 'like', "%{$filters['search']}%");
            $query->orWhere('address', 'like', "%{$filters['search']}%");
            $query->orWhere('city', 'like', "%{$filters['search']}%");
            $query->orWhere('state', 'like', "%{$filters['search']}%");
            $query->orWhere('country', 'like', "%{$filters['search']}%");
            $query->orWhere('status', 'like', "%{$filters['search']}%");
            $query->orWhere('login_attempt_data', 'like', "%{$filters['search']}%");
        }

        //Display Trashed
        if (isset($filters['trashed']) && $filters['trashed'] === true) {
            $query->onlyTrashed();
        }

        if (!empty($filters['user_id'])) {
            $query->where('user_id', '=', $filters['user_id']);
        }

        if (!empty($filters['id_not_in'])) {
            $query->whereNotIn($this->model->getKeyName(), (array)$filters['id_not_in']);
        }

        if (!empty($filters['id_in'])) {
            $query->whereIn($this->model->getKeyName(), (array)$filters['id_in']);
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
