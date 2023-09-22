<?php

namespace Fintech\Auth\Exceptions;

/**
 * Class TeamRepositoryException
 */
class TeamRepositoryException extends \Exception
{
    public function __construct($message = '', $code = 0, \Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
