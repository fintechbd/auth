<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\LoginAttemptRepository;

/**
 * Class LoginAttemptService
 * @package Fintech\Auth\Services
 *
 */
class LoginAttemptService
{
    use \Fintech\Core\Traits\HasFindWhereSearch;

    /**
     * LoginAttemptService constructor.
     * @param LoginAttemptRepository $loginAttemptRepository
     */
    public function __construct(private readonly LoginAttemptRepository $loginAttemptRepository)
    {
    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->loginAttemptRepository->find($id, $onlyTrashed);
    }

    public function destroy($id)
    {
        return $this->loginAttemptRepository->delete($id);
    }

    public function restore($id)
    {
        return $this->loginAttemptRepository->restore($id);
    }

    public function export(array $filters)
    {
        return $this->loginAttemptRepository->list($filters);
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->loginAttemptRepository->list($filters);

    }

    public function import(array $filters)
    {
        return $this->loginAttemptRepository->create($filters);
    }

    public function create(array $inputs = [])
    {
        return $this->loginAttemptRepository->create($inputs);
    }
}
