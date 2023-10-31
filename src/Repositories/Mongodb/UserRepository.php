<?php

namespace Fintech\Auth\Repositories\Mongodb;

use Fintech\Auth\Interfaces\UserRepository as InterfacesUserRepository;
use Fintech\Auth\Models\User;
use Fintech\Core\Repositories\MongodbRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class UserRepository
 */
class UserRepository extends MongodbRepository implements InterfacesUserRepository
{
    public function __construct()
    {
        $model = app(config('fintech.auth.user_model', User::class));

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

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        if (isset($filters['login_id']) && ! empty($filters['login_id'])) {
            $query->where('login_id', $filters['login_id'])->limit(1);
        }

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
