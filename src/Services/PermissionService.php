<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\PermissionRepository;
use Fintech\Auth\Models\Permission;
use Fintech\Core\Abstracts\BaseModel;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Collection;

/**
 * Class PermissionService
 *
 */
class PermissionService
{
    use \Fintech\Core\Traits\HasFindWhereSearch;

    /**
     * PermissionService constructor.
     * @param PermissionRepository $permissionRepository
     */
    public function __construct(private readonly PermissionRepository $permissionRepository)
    {
    }

    /**
     * @return BaseModel|Permission|null
     */
    public function find($id, $onlyTrashed = false)
    {
        return $this->permissionRepository->find($id, $onlyTrashed);
    }

    /**
     * @return BaseModel|Permission|null
     */
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

    public function export(array $filters)
    {
        return $this->permissionRepository->list($filters);
    }

    /**
     * @return Paginator|Collection
     */
    public function list(array $filters = [])
    {
        return $this->permissionRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->permissionRepository->create($filters);
    }

    public function create(array $inputs = [])
    {
        return $this->permissionRepository->create($inputs);
    }
}
