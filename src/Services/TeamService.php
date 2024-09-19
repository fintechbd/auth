<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\TeamRepository;

/**
 * Class TeamService
 *
 */
class TeamService extends \Fintech\Core\Abstracts\Service
{
    /**
     * TeamService constructor.
     * @param TeamRepository $teamRepository
     */
    public function __construct(private readonly TeamRepository $teamRepository)
    {
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

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $countryList = $this->teamRepository->list($filters);

        //Do Business Stuff

        return $countryList;

    }

    public function import(array $filters)
    {
        return $this->teamRepository->create($filters);
    }

    public function create(array $inputs = [])
    {
        return $this->teamRepository->create($inputs);
    }
}
