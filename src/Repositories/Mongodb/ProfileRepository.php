<?php

namespace Fintech\Auth\Repositories\Mongodb;

use Fintech\Auth\Interfaces\ProfileRepository as InterfacesProfileRepository;
use Fintech\Auth\Models\Profile;
use Fintech\Core\Repositories\MongodbRepository;
use Illuminate\Contracts\Pagination\Paginator;
use InvalidArgumentException;
use MongoDB\Laravel\Collection;
use MongoDB\Laravel\Eloquent\Model;

/**
 * Class UserProfileRepository
 */
class ProfileRepository extends MongodbRepository implements InterfacesProfileRepository
{
    public function __construct()
    {
        $model = app(config('fintech.auth.profile_model', Profile::class));

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

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['dir'] ?? 'asc');

        //Execute Output
        return $this->executeQuery($query, $filters);

    }
}
