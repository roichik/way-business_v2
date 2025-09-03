<?php

namespace App\Exceptions;

use App\Dictionaries\MessageCodeDictionary;
use App\Models\Translation;
use Infrastructure\Dto\AbstractDto;

/**
 * Class Exception
 */
class Exception extends \Exception
{
    /**
     * @param string|array $message
     * @param int $statusCode
     * @param \Throwable|null $previous
     */
    public function __construct(string|array $message = "", int $statusCode = 500, ?\Throwable $previous = null)
    {
        parent::__construct($this->formatMessage($message), $statusCode, $previous);
    }

    /**
     * @param mixed $message
     * @return string
     */
    protected function formatMessage(string|array $message)
    {
        if (is_array($message)) {
            return json_encode($message);
        } else {

        }

        return $message;
    }
}
