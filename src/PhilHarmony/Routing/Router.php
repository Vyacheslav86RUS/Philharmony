<?php

namespace PhilHarmony\Routing;

class Router
{
    /**
     * @var Route[]
     */
    private $route;

    /**
     * @return Route[]
     */
    public function getRoute(): array
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route): void
    {
        $this->route[] = $route;
    }
}
