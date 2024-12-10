<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Interfaces\FavouriteRepository as InterfacesFavouriteRepository;
use Fintech\Auth\Models\Favourite;
use Fintech\Core\Repositories\EloquentRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class FavouriteRepository
 * @package Fintech\Auth\Repositories\Eloquent
 */
class FavouriteRepository extends EloquentRepository implements InterfacesFavouriteRepository
{
    public function __construct()
    {
        parent::__construct(config('fintech.auth.favourite_model', Favourite::class));
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
                $query->orWhere('favourite_data', 'like', "%{$filters['search']}%");
            }
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

        if (!empty($filters['sender_id'])) {
            $query->where('sender_id', '=', $filters['sender_id']);
        }

        if (!empty($filters['receiver_id'])) {
            $query->where('receiver_id', '=', $filters['receiver_id']);
        }

        if (!empty($filters['status'])) {
            $query->whereIn('status', (array)$filters['status']);
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
