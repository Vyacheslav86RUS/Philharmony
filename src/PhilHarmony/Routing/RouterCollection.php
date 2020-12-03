<?php

namespace PhilHarmony\Routing;

class RouterCollection
{
    /**
     * @var array
     */
    private $routesCollection;

    public function getRouterCollection(): array
    {
        return $this->routesCollection;
    }

    /**
     * @param string $method
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function setRouterCollection(string $method, string $url, $callable): self
    {
        $this->routesCollection[$method][$url] = $callable;

        return $this;
    }
}
