<?php

namespace Fintech\Auth\Exceptions;

use Exception;
use Throwable;

/**
 * Class AuthException
 */
class AuthException extends Exception
{
    /**
     * AuthException constructor.
     *
     * @param string $message
     * @param int $code
     */
    public function __construct($message = '', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
