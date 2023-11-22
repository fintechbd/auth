<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\UserRepository as InterfacesUserRepository;
use Fintech\Auth\Models\User;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Pagination\Paginator;
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
        $model = app(config('fintech.auth.user_model', User::class));

        if (!$model instanceof Model) {
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
        $authField = config('fintech.auth.auth_field', 'login_id');

        $query = $this->model->newQuery();

        if (isset($filters['search']) && !empty($filters['search'])) {
            if (is_numeric($filters['search'])) {
                $query->where($this->model->getKeyName(), 'like', "%{$filters['search']}%");
            } else {
                $query->where('name', 'like', "%{$filters['search']}%");
            }
        }

        //auth field search
        if (isset($filters[$authField]) && !empty($filters[$authField])) {
            $query->where($authField, '=', $filters[$authField]);
        }

        if (isset($filters['email']) && !empty($filters['email'])) {
            $query->where('email', '=', $filters['email']);
        }

        if (isset($filters['mobile']) && !empty($filters['mobile'])) {
            $query->where('mobile', '=', $filters['mobile']);
        }

        if (isset($filters['name']) && !empty($filters['name'])) {
            $query->where('name', '=', $filters['name']);
        }

        if (isset($filters['trashed']) && !empty($filters['trashed'])) {

            $query->onlyTrashed();
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
