<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\TeamRepository;

/**
 * Class TeamService
 *
 */
class TeamService
{
    /**
     * @var TeamRepository
     */
    private TeamRepository $teamRepository;

    /**
     * TeamService constructor.
     * @param TeamRepository $teamRepository
     */
    public function __construct(TeamRepository $teamRepository)
    {
        $this->teamRepository = $teamRepository;
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

    public function export(array $filters)
    {
        return $this->teamRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->teamRepository->create($filters);
    }
}
