<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\TeamRepository;

/**
 * Class TeamService
 *
 * @property-read TeamRepository $teamRepository
 */
class TeamService
{
    /**
     * TeamService constructor.
     */
    public function __construct(private TeamRepository $teamRepository)
    {
    }

    /**
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

    public function find($id, $onlyTrashed = false)
    {
        return $this->teamRepository->find($id, $onlyTrashed);
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
