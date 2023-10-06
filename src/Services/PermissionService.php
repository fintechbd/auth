<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\PermissionRepository;

/**
 * Class PermissionService
 *
 */
class PermissionService
{
    /**
     * @var PermissionRepository
     */
    private PermissionRepository $permissionRepository;

    /**
     * PermissionService constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $permissionList = $this->permissionRepository->list($filters);

        //Do Business Stuff

        return $permissionList;

    }

    public function create(array $inputs = [])
    {
        return $this->permissionRepository->create($inputs);
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->permissionRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->permissionRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->permissionRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->permissionRepository->restore($id);
    }
}
