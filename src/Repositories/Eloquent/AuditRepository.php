<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\AuditRepository as InterfacesAuditRepository;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class AuditRepository
 * @package Fintech\Auth\Repositories\Eloquent
 */
class AuditRepository extends EloquentRepository implements InterfacesAuditRepository
{
    public function __construct()
    {
        $model = app(config('fintech.auth.audit_model', \Fintech\Auth\Models\Audit::class));

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
        $query = $this->model->newQuery();

        //Searching
        if (isset($filters['search']) && !empty($filters['search'])) {
            if (is_numeric($filters['search'])) {
                $query->where($this->model->getKeyName(), 'like', "%{$filters['search']}%");
            } else {
                $query->where('name', 'like', "%{$filters['search']}%");
            }
        }

        //Display Trashed
        if (isset($filters['trashed']) && !empty($filters['trashed'])) {
            $query->onlyTrashed();
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }

    public function create(array $attributes = [])
    {
        return throw new \ErrorException(__('auth::message.audit.create'));
    }

    public function update(int|string $id, array $attributes = [])
    {
        return throw new \ErrorException(__('auth::message.audit.update'));
    }

    public function restore(int|string $id)
    {
        return throw new \ErrorException(__('auth::message.audit.restore'));
    }
}
