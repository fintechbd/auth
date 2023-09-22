<?php

namespace Fintech\Auth\Exceptions;

/**
 * Class RoleRepositoryException
 */
class RoleRepositoryException extends \Exception
{
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
