<?php

namespace Fintech\Auth\Services;


use Fintech\Auth\Interfaces\PermissionRepository;

/**
 * Class PermissionService
 * @package Fintech\Auth\Services
 *
 * @property-read PermissionRepository $permissionRepository
 */
class PermissionService
{
    /**
     * PermissionService constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(private PermissionRepository $permissionRepository) { }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $countryList = $this->permissionRepository->list($filters);

        //Do Business Stuff

        return $countryList;

    }

    public function create(array $inputs = [])
    {
        return $this->permissionRepository->create($inputs);
    }

    public function read($id)
    {
        return $this->permissionRepository->read($id);
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
