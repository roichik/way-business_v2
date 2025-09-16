<?php

namespace App\Exceptions;

/**
 * Class InvalidCredentialsException
 */
class InvalidCredentialsException extends CustomException
{
    public function __construct(string $message = "Invalid credentials", int $statusCode = 403, ?\Throwable $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
    }
}
