<?php

namespace Fintech\Auth\Repositories\Eloquent;

use Fintech\Auth\Exceptions\Eloquent\RoleRepository;
use Fintech\Auth\Interfaces\CountryRepository as InterfacesCountryRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use InvalidArgumentException;

/**
 * Class RoleRepository
 * @package Fintech\Auth\Repositories\Eloquent
 */
class RoleRepository implements InterfacesCountryRepository
{
    /**
     * @var $model Model
     */
    private Model $model;

    public function __construct()
    {
       $model = app()->make(config('auth.country_model', \App\Models\Country::class));

       if (!$model instanceof Model) {
           throw new InvalidArgumentException("Eloquent repository require model class to be `Illuminate\Database\Eloquent\Model` instance.");
       }

       $this->model = $model;
    }

    /**
     * return a list or pagination of items from
     * filtered options
     *
     * @param array $filters
     * @return LengthAwarePaginator|Builder[]|Collection
     */
    public function list(array $filters = [])
    {
        $query = $this->model->newQuery();

        //Handle Sorting
        $query->orderBy($filters['sort'] ?? $this->model->getKeyName(), $filters['direction'] ?? 'asc');

        //Prepare Output
        return (isset($filters['paginate']) && $filters['paginate'] == true)
            ? $query->paginate(($filters['per_page'] ?? 20))
            : $query->get();

    }

    /**
     * Create a new entry resource
     *
     * @param array $attributes
     * @return Model|null
     * @throws RoleRepositoryException
     */
    public function create(array $attributes = [])
    {
        try {
            if ($this->model->saveOrFail($attributes)) {

                $this->model->refresh();

                return $this->model;
            }
        } catch (\Throwable $e) {

            throw new RoleRepositoryException($e->getMessage(), 0, $e);
        }

        return null;
    }

    /**
     * find and update a resource attributes
     *
     * @param int|string $id
     * @param array $attributes
     * @return Model|null
     * @throws RoleRepositoryException
     */
    public function update(int|string $id, array $attributes = [])
    {
        try {

            $this->model = $this->model->findOrFail($id);

        } catch (\Throwable $exception) {

            throw new ModelNotFoundException($exception->getMessage(), 0, $exception);
        }

        try {
            if ($this->model->updateOrFail($attributes)) {

                $this->model->refresh();

                return $this->model;
            }
        } catch (\Throwable $exception) {

            throw new RoleRepositoryException($exception->getMessage(), 0, $exception);
        }

        return null;
    }

    /**
     * find and delete a entry from records
     *
     * @param string|int $id
     * @param bool $onlyTrashed
     * @return bool|null
     * @throws RoleRepositoryException
     */
    public function read(int|string $id, $onlyTrashed = false)
    {
        try {

            $this->model = $this->model->findOrFail($id);

        } catch (\Throwable $exception) {

            throw new ModelNotFoundException($exception->getMessage(), 0, $exception);
        }

        try {

            return $this->model->deleteOrFail();

        } catch (\Throwable $exception) {

            throw new RoleRepositoryException($exception->getMessage(), 0, $exception);
        }

        return null;
    }

    /**
     * find and delete a entry from records
     *
     * @param string|int $id
     * @return bool|null
     * @throws RoleRepositoryException
     */
    public function delete(int|string $id)
    {
        try {

            $this->model = $this->model->findOrFail($id);

        } catch (\Throwable $exception) {

            throw new ModelNotFoundException($exception->getMessage(), 0, $exception);
        }

        try {

            return $this->model->deleteOrFail();

        } catch (\Throwable $exception) {

            throw new RoleRepositoryException($exception->getMessage(), 0, $exception);
        }

        return null;
    }

    /**
     * find and restore a entry from records
     *
     * @param string|int $id
     * @return bool|null
     * @throws RoleRepositoryException
     */
    public function restore(int|string $id)
    {
        if (!method_exists($this->model, 'restore')) {
            throw new InvalidArgumentException('This model does not have `Illuminate\Database\Eloquent\SoftDeletes` trait to perform restoration.');
        }

        try {

            $this->model = $this->model->onlyTrashed()->findOrFail($id);

        } catch (\Throwable $exception) {

            throw new ModelNotFoundException($exception->getMessage(), 0, $exception);
        }

        try {

            return $this->model->deleteOrFail();

        } catch (\Throwable $exception) {

            throw new RoleRepositoryException($exception->getMessage(), 0, $exception);
        }

        return null;
    }
}
