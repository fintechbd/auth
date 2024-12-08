<?php

namespace Fintech\Auth\Services;

use Fintech\Auth\Interfaces\AuditRepository;
use Fintech\Auth\Models\Audit;
use Fintech\Core\Abstracts\BaseModel;

/**
 * Class AuditService
 * @package Fintech\Auth\Services
 *
 */
class AuditService
{
    use \Fintech\Core\Traits\HasFindWhereSearch;

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

    /**
     * @return BaseModel|Audit|null
     */
    public function find($id, $onlyTrashed = false)
    {
        return $this->auditRepository->find($id, $onlyTrashed);
    }

    public function destroy($id)
    {
        return $this->auditRepository->delete($id);
    }
}
