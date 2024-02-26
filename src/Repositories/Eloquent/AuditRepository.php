<?php

namespace Fintech\Auth\Repositories\Eloquent;

use ErrorException;
use Fintech\Auth\Interfaces\AuditRepository as InterfacesAuditRepository;
use Fintech\Auth\Models\Audit;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class AuditRepository
 * @package Fintech\Auth\Repositories\Eloquent
 */
class AuditRepository extends EloquentRepository implements InterfacesAuditRepository
{
    public function __construct()
    {
        parent::__construct(config('fintech.auth.audit_model', Audit::class));
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

    /**
     * @throws ErrorException
     */
    public function create(array $attributes = [])
    {
        return throw new ErrorException(__('auth::message.audit.create'));
    }

    /**
     * @throws ErrorException
     */
    public function update(int|string $id, array $attributes = [])
    {
        return throw new ErrorException(__('auth::message.audit.update'));
    }

    /**
     * @throws ErrorException
     */
    public function restore(int|string $id)
    {
        return throw new ErrorException(__('auth::message.audit.restore'));
    }
}
