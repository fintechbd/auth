<?php

namespace Fintech\Auth\Exceptions;

/**
 * Class RoleRepositoryException
 * @package Fintech\Auth\Exceptions
 */
class RoleRepositoryException extends \Exception
{
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
