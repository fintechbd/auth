<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\AuditRepository;

/**
 * Class AuditService
 * @package Fintech\Auth\Services
 *
 */
class AuditService
{
    /**
     * AuditService constructor.
     * @param AuditRepository $auditRepository
     */
    public function __construct(private AuditRepository $auditRepository)
    {
    }

    /**
     * @param array $filters
     * @return mixed
     */
    public function list(array $filters = [])
    {
        return $this->auditRepository->list($filters);

    }

    public function find($id, $onlyTrashed = false)
    {
        return $this->auditRepository->find($id, $onlyTrashed);
    }

    public function destroy($id)
    {
        return $this->auditRepository->delete($id);
    }
}
