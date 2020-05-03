<?php

namespace PhilHarmony\src\Routing;

use PhilHarmony\src\Exception\PhilHarmonyRouterCollectionException;

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

    public function getRouter(string $keyRoute): Router
    {
        if (!isset($this->routesCollection[$keyRoute])) {
            throw new PhilHarmonyRouterCollectionException();
        }

        return $this->routesCollection[$keyRoute];
    }

    public function setRouterCollection(string $keyRoute, Router $router): self
    {
        $this->routesCollection[$keyRoute] = $router;

        return $this;
    }
}
