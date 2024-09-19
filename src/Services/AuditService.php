<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\AuditRepository;

/**
 * Class AuditService
 * @package Fintech\Auth\Services
 *
 */
class AuditService extends \Fintech\Core\Abstracts\Service
{
    /**
     * AuditService constructor.
     * @param AuditRepository $auditRepository
     */
    public function __construct(private readonly AuditRepository $auditRepository)
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
