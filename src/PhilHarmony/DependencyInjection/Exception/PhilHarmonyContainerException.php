<?php

namespace PhilHarmony\DependencyInjection\Exception;

use Exception;
use Psr\Container\NotFoundExceptionInterface;

class PhilHarmonyContainerException extends Exception implements NotFoundExceptionInterface
{
}
