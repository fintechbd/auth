<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\FavouriteRepository;
use Fintech\Auth\Models\Favourite;
use Fintech\Core\Abstracts\BaseModel;

/**
 * Class FavouriteService
 * @package Fintech\Auth\Services
 *
 */
class FavouriteService
{
    use \Fintech\Core\Traits\HasFindWhereSearch;

    /**
     * FavouriteService constructor.
     * @param FavouriteRepository $favouriteRepository
     */
    public function __construct(public FavouriteRepository $favouriteRepository)
    {
    }

    /**
     * @return BaseModel|Favourite|null
     */
    public function find($id, $onlyTrashed = false)
    {
        return $this->favouriteRepository->find($id, $onlyTrashed);
    }

    /**
     * @return BaseModel|Favourite|null
     */
    public function update($id, array $inputs = [])
    {
        return $this->favouriteRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->favouriteRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->favouriteRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->favouriteRepository->list($filters);
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->favouriteRepository->list($filters);

    }

    public function import(array $filters)
    {
        return $this->favouriteRepository->create($filters);
    }

    /**
     * @throws \Exception
     */
    public function create(array $inputs = [])
    {
        $relationExists = $this->favouriteRepository->list(['pair_exists' => [$inputs['sender_id'], $inputs['receiver_id']]])->isNotEmpty();

        if ($relationExists) {
            throw new \Exception(__('auth::messages.favourite.already_exists'));
        }

        return $this->favouriteRepository->create($inputs);
    }
}
