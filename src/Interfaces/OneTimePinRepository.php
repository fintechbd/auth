<?php

namespace Fintech\Auth\Interfaces;

interface OneTimePinRepository
{
    /**
     * Create a new token.
     *
     * @param string $authField
     * @param string $token
     * @throws \Exception
     */
    public function create(string $authField, string $token);

    /**
     * Determine if a token record exists and is valid.
     *
     * @param string $token
     * @return bool
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
