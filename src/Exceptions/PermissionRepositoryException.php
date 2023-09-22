<?php

namespace Fintech\Auth\Exceptions;

/**
 * Class PermissionRepositoryException
 */
class PermissionRepositoryException extends \Exception
{
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
