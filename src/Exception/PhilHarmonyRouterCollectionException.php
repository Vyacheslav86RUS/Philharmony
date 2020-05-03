<?php

namespace PhilHarmony\src\Exception;

use Throwable;

class PhilHarmonyRouterCollectionException extends PhilHarmonyException
{
    protected $message;

    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
