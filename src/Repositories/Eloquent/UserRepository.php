<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\UserRepository as InterfacesUserRepository;
use Fintech\Auth\Models\User;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserRepository
 */
class UserRepository extends EloquentRepository implements InterfacesUserRepository
{
    public function __construct()
    {
        parent::__construct(config('fintech.auth.user_model', User::class));
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

        if (!empty($filters['search'])) {
            $query->where('name', 'like', "%{$filters['search']}%")
                ->orWhere('email', 'like', "%{$filters['search']}%")
                ->orWhere('mobile', 'like', "%{$filters['search']}%")
                ->orWhere('login_id', 'like', "%{$filters['search']}%")
                ->orWhere('status', 'like', "%{$filters['search']}%")
                ->orWhere('currency', 'like', "%{$filters['search']}%");
        }

        //auth field search
        if (!empty($filters[$authField])) {
            $query->where($authField, '=', $filters[$authField]);
        }

        if (!empty($filters['user_id'])) {
            $query->where($this->model->getKeyName(), '=', $filters['user_id']);
        }

        if (!empty($filters['email'])) {
            $query->where('email', '=', $filters['email']);
        }

        if (!empty($filters['mobile'])) {
            $query->where('mobile', '=', $filters['mobile']);
        }

        if (!empty($filters['name'])) {
            $query->where('name', '=', $filters['name']);
        }

        if (!empty($filters['present_country_id'])) {
            $query->whereHas('profile', function (Builder $builder) use (&$filters) {
                return $builder->where('present_country_id', '=', $filters['present_country_id']);
            });
        }

        if (!empty($filters['role_name'])) {
            $query->whereHas('roles', function (Builder $builder) use (&$filters) {
                return $builder->where('name', '=', $filters['role_name']);
            });
        }

        if (isset($filters['trashed']) && $filters['trashed'] === true) {

            $query->onlyTrashed();
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
