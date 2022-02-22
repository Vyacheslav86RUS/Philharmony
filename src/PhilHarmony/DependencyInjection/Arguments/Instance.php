<?php

namespace PhilHarmony\DependencyInjection\Arguments;

class Instance
{
    /**
     * @var Instance[]
     */
    private $instance;

    public function getInstance(string $name): array
    {
        return $this->instance[$name];
    }

    public function setInstance(string $name, object $obj): Instance
    {
        $this->instance[$name] = $obj;

        return $this->instance;
    }

    public function has(string $name): bool
    {
        return isset($this->instance[$name]);
    }
}
