<?php

namespace Fintech\Auth\Interfaces;

interface OneTimePinRepository
{
    /**
     * Create a new token.
     *
     * @param string $authField
     * @return null|string
     * @throws \Exception
     */
    public function create(string $authField);

    /**
     * Determine if a token record exists and is valid.
     *
     * @param string $authField
     * @param string $token
     * @return bool
     */
    public function exists(string $authField, string $token);
}
