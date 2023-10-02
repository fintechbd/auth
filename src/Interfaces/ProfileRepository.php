<?php

namespace Fintech\Auth\Interfaces;

use Fintech\Auth\Exceptions\ProfileRepositoryException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model as EloquentModel;
use MongoDB\Laravel\Eloquent\Model as MongodbModel;

/**
 * Interface UserProfileRepository
 */
interface ProfileRepository
{
    /**
     * return a list or pagination of items from
     * filtered options
     *
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function list(array $filters = []);

    /**
     * Create a new entry resource
     *
     * @return EloquentModel|MongodbModel|null
     *
     * @throws ProfileRepositoryException
     */
    public function create(array $attributes = []);

    /**
     * find and update a resource attributes
     *
     * @return EloquentModel|MongodbModel|null
     *
     * @throws ProfileRepositoryException
     */
    public function update(int|string $id, array $attributes = []);

    /**
     * find and delete a entry from records
     *
     * @param  bool  $onlyTrashed
     * @return EloquentModel|MongodbModel|null
     *
     * @throws ProfileRepositoryException
     */
    public function find(int|string $id, $onlyTrashed = false);

    /**
     * find and delete a entry from records
     *
     * @throws ProfileRepositoryException
     */
    public function delete(int|string $id);

    /**
     * find and restore a entry from records
     *
     * @throws \InvalidArgumentException
     * @throws ProfileRepositoryException
     */
    public function restore(int|string $id);
}
