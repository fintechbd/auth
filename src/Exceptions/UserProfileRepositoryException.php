<?php

namespace Fintech\Auth\Exceptions;

/**
 * Class UserProfileRepositoryException
 * @package Fintech\Auth\Exceptions
 */
class UserProfileRepositoryException extends \Exception
{
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
