<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\IdDocTypeRepository as InterfacesIdDocTypeRepository;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class IdDocTypeRepository
 * @package Fintech\Auth\Repositories\Eloquent
 */
class IdDocTypeRepository extends EloquentRepository implements InterfacesIdDocTypeRepository
{
    public function __construct()
    {
        $model = app(config('fintech.auth.id_doc_type_model', \Fintech\Auth\Models\IdDocType::class));

        if (!$model instanceof Model) {
            throw new InvalidArgumentException("Eloquent repository require model class to be "
                ."`Illuminate\Database\Eloquent\Model` instance.");
        }

        $this->model = $model;
    }

    /**
     * return a list or pagination of items from
     * filtered options
     *
     * @return Paginator|Collection
     * @throws BindingResolutionException
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
                $query->orWhere('code', 'like', "%{$filters['search']}%");
                $query->orWhere('id_doc_type_data', 'like', "%{$filters['search']}%");
            }
        }

        if (!empty($filters['country_id'])) {
            $query->where('country_id', '=', $filters['country_id']);
        }

        if (!empty($filters['country_name'])) {
            $query->join(
                get_table('metadata.country'),
                $this->model->getTable() . '.country_id',
                '=',
                get_table('metadata.country') . '.id'
            )
                ->where(get_table('metadata.country') . '.name',
                    'like', strtolower("%{$filters['country_name']}%"));
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
