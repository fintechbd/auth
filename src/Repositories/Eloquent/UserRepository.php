<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\UserRepository as InterfacesUserRepository;
use Fintech\Auth\Models\User;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class UserRepository
 */
class UserRepository extends EloquentRepository implements InterfacesUserRepository
{
    public function __construct()
    {
        $model = app()->make(config('fintech.auth.user_model', User::class));

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

        if (isset($filters['login_id']) && ! empty($filters['login_id'])) {
            $query->where('login_id', $filters['login_id'])->limit(1);
        }

        //Prepare Output
        return (isset($filters['paginate']) && $filters['paginate'] == true)
            ? $query->paginate(($filters['per_page'] ?? 20))
            : $query->get();

    }

}
