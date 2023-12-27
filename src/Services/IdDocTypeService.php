<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\IdDocTypeRepository;
use Fintech\Auth\Interfaces\ProfileRepository;

/**
 * Class IdDocTypeService
 * @package Fintech\Auth\Services
 *
 */
class IdDocTypeService
{
    /**
     * IdDocTypeService constructor.
     * @param IdDocTypeRepository $idDocTypeRepository
     * @param ProfileRepository $profileRepository
     */
    public function __construct(
        private readonly IdDocTypeRepository $idDocTypeRepository,
        private readonly ProfileRepository   $profileRepository
    ) {
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->idDocTypeRepository->list($filters);

    }

    public function create(array $inputs = [])
    {
        return $this->idDocTypeRepository->create($inputs);
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->idDocTypeRepository->find($id, $onlyTrashed);
    }

    public function update($id, array $inputs = [])
    {
        return $this->idDocTypeRepository->update($id, $inputs);
    }

    public function destroy($id)
    {
        return $this->idDocTypeRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->idDocTypeRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->idDocTypeRepository->list($filters);
    }

    public function import(array $filters)
    {
        return $this->idDocTypeRepository->create($filters);
    }

    public function verify(array $inputs): mixed
    {
        return $this->profileRepository->list($inputs)->first();
    }
}
