<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Core\Repositories\EloquentRepository;
use Fintech\Auth\Interfaces\FavouriteRepository as InterfacesFavouriteRepository;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

/**
 * Class FavouriteRepository
 * @package Fintech\Auth\Repositories\Eloquent
 */
class FavouriteRepository extends EloquentRepository implements InterfacesFavouriteRepository
{
    public function __construct()
    {
       $model = app(config('fintech.auth.favourite_model', \Fintech\Auth\Models\Favourite::class));

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
        if (! empty($filters['search'])) {
            if (is_numeric($filters['search'])) {
                $query->where($this->model->getKeyName(), 'like', "%{$filters['search']}%");
            } else {
                $query->where('name', 'like', "%{$filters['search']}%");
                $query->orWhere('favourite_data', 'like', "%{$filters['search']}%");
            }
        }

        //Display Trashed
        if (isset($filters['trashed']) && $filters['trashed'] === true) {
            $query->onlyTrashed();
        }

        if (!empty($filters['sender_id'])) {
            $query->where('sender_id','=', $filters['sender_id']);
        }

        if (!empty($filters['receiver_id'])) {
            $query->where('receiver_id','=', $filters['receiver_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status','=', $filters['status']);
        }

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
