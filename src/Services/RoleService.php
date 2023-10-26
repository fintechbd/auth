<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\RoleRepository;

/**
 * Class RoleService
 *
 */
class RoleService
{
    /**
     * RoleService constructor.
     * @param RoleRepository $roleRepository
     */
    public function __construct(private RoleRepository $roleRepository)
    {
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $roleList = $this->roleRepository->list($filters);

        //Do Business Stuff

        return $roleList;

    }

    public function create(array $inputs = [])
    {
        return $this->roleRepository->create($inputs);
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->roleRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->roleRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->roleRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->roleRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->roleRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->roleRepository->create($filters);
    }
}
