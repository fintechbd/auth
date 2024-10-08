<?php

namespace Fintech\Auth\Repositories\Mongodb;

use Fintech\Auth\Interfaces\LoginAttemptRepository as InterfacesLoginAttemptRepository;
use Fintech\Auth\Models\LoginAttempt;
use Fintech\Core\Repositories\MongodbRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class LoginAttemptRepository
 * @package Fintech\Auth\Repositories\Mongodb
 */
class LoginAttemptRepository extends MongodbRepository implements InterfacesLoginAttemptRepository
{
    public function __construct()
    {
        parent::__construct(config('fintech.auth.login_attempt_model', LoginAttempt::class));
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
            if (is_numeric($filters['search'])) {
                $query->where($this->model->getKeyName(), 'like', "%{$filters['search']}%");
            } else {
                $query->where('name', 'like', "%{$filters['search']}%");
                $query->orWhere('login_attempt_data', 'like', "%{$filters['search']}%");
            }
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
