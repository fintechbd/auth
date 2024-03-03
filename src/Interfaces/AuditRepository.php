<?php

namespace Fintech\Auth\Interfaces;

use Illuminate\Contracts\Pagination\Paginator;
use Fintech\Core\Abstracts\BaseModel;
use Illuminate\Support\Collection;

/**
 * Interface AuditRepository
 * @package Fintech\Auth\Interfaces
 */
interface AuditRepository
{
    /**
     * return a list or pagination of items from
     * filtered options
     *
     * @param array $filters
     * @return Paginator|Collection
     */
    public function list(array $filters = []);

    /**
     * find and delete a entry from records
     *
     * @param int|string $id
     * @param bool $onlyTrashed
     * @return BaseModel
     */
    public function find(int|string $id, $onlyTrashed = false);

    /**
     * find and delete a entry from records
     * @param int|string $id
     */
    public function delete(int|string $id);

}
