<?php

namespace PhilHarmony\src\Http;

class Request
{
    public function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
}
