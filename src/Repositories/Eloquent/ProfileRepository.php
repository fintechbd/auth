<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\ProfileRepository as InterfacesProfileRepository;
use Fintech\Auth\Models\Profile;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class UserProfileRepository
 */
class ProfileRepository extends EloquentRepository implements InterfacesProfileRepository
{
    public function __construct()
    {
        parent::__construct(config('fintech.auth.profile_model', Profile::class));
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
                $query->where('name', 'like', "%{$filters['search']}%");
            }
        }

        if (!empty($filters['id_type'])) {
            $query->where('id_type', '=', $filters['id_type']);
        }

        if (!empty($filters['id_no'])) {
            $query->where('id_no', '=', $filters['id_no']);
        }

        if (!empty($filters['id_issue_country'])) {
            $query->where('id_issue_country', '=', $filters['id_issue_country']);
        }

        if (!empty($filters['id_not_in'])) {
            $query->whereNotIn($this->model->getKeyName(), (array)$filters['id_not_in']);
        }

        if (!empty($filters['id_in'])) {
            $query->whereIn($this->model->getKeyName(), (array)$filters['id_in']);
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
