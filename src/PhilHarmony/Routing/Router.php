<?php

namespace PhilHarmony\src\Routing;

class Router
{
    /**
     * @var string
     */
    private $route;

    /**
     * @return string
     */
    public function getRoute(): string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    public function setRoute(string $route): void
    {
        $this->route = $route;
    }

}
