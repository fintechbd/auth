<?php

namespace Fintech\Auth\Services;


use Fintech\Auth\Interfaces\TeamRepository;

/**
 * Class TeamService
 * @package Fintech\Auth\Services
 *
 * @property-read TeamRepository $teamRepository
 */
class TeamService
{
    /**
     * TeamService constructor.
     * @param TeamRepository $teamRepository
     */
    public function __construct(private TeamRepository $teamRepository) { }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $countryList = $this->teamRepository->list($filters);

        //Do Business Stuff

        return $countryList;

    }

    public function create(array $inputs = [])
    {
        return $this->teamRepository->create($inputs);
    }

    public function read($id)
    {
        return $this->teamRepository->read($id);
    }

    public function update($id, array $inputs = [])
    {
        return $this->teamRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->teamRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->teamRepository->restore($id);
    }
}
