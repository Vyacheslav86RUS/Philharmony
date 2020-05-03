<?php

namespace PhilHarmony\src\Exception;

use Exception;
use Throwable;

class PhilHarmonyException extends Exception
{
    protected $message;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
