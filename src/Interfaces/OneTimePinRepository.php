<?php

namespace Fintech\Auth\Interfaces;

use Exception;
use Fintech\Core\Abstracts\BaseModel;


interface OneTimePinRepository
{
    /**
     * Create a new token.
     *
     * @param string $authField
     * @param string $token
     * @return BaseModel
     * @throws Exception
     */
    public function create(string $authField, string $token);

    /**
     * Determine if a token record exists and is valid.
     *
     * @param string $token
     * @return BaseModel
     */
    public function exists(string $token);

    /**
     * Delete expired tokens.
     *
     * @param string $authField
     * @return void
     */
    public function deleteExpired(string $authField);

    /**
     * Delete existing old tokens.
     *
     * @param string $authField
     * @return void
     */
    public function delete(string $authField);
}
