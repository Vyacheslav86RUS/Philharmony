<?php

namespace PhilHarmony\DependencyInjection\Arguments;

class Singleton
{
    /**
     * @var Singleton[]
     */
    private $singletons;

    /**
     * @param string $name
     * @return Singleton
     */
    public function getSingletons(string $name): Singleton
    {
        return $this->singletons[$name];
    }

    /**
     * @param string $name
     * @param object $obj
     * @return $this
     */
    public function setSingletons(string $name, object $obj): Singleton
    {
        $this->singletons[$name] = $obj;

        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->singletons[$name]);
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeSingletons(string $name): Singleton
    {
        if ($this->has($name)) {
            unset($this->singletons[$name]);
        }

        return $this;
    }
}
