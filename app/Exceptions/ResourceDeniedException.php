<?php

namespace App\Exceptions;

/**
 * Class ResourceDeniedException
 */
class ResourceDeniedException extends CustomException
{
    public function __construct(string $message = "Access to resource is denied", int $statusCode = 403, ?\Throwable $previous = null)
    {
        parent::__construct($message, $statusCode, $previous);
    }
}
