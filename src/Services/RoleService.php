<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\RoleRepository;

/**
 * Class RoleService
 *
 * @property-read RoleRepository $roleRepository
 */
class RoleService
{
    /**
     * RoleService constructor.
     */
    public function __construct(private RoleRepository $roleRepository)
    {
    }

    /**
     * @return mixed
     */
    public function list(array $filters = [])
    {
        $countryList = $this->roleRepository->list($filters);

        //Do Business Stuff

        return $countryList;

    }

    public function create(array $inputs = [])
    {
        return $this->roleRepository->create($inputs);
    }

    public function read($id)
    {
        return $this->roleRepository->read($id);
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
}
