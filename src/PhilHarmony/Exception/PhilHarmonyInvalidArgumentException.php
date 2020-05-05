<?php

namespace PhilHarmony\Exception;

use InvalidArgumentException;
use Throwable;

class PhilHarmonyInvalidArgumentException extends InvalidArgumentException
{
    protected $message;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
