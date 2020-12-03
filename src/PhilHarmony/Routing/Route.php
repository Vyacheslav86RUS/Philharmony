<?php

namespace PhilHarmony\Routing;

use PhilHarmony\Http\Request;
use PhilHarmony\Http\Response;

class Route extends BaseRoute
{
    /**
     * @var RouterCollection
     */
    private $routeCollection;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;


    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->routeCollection = new RouterCollection();
    }

    /**
     * @param string $method
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function addRoute(string $method, string $url, $callable): self
    {
        $this->routeCollection->setRouterCollection($method, $url, $callable);

        return $this;
    }

    public function resolve(): ?string
    {
        $collection = $this->routeCollection->getRouterCollection();
        $callback = $collection[$this->request->getMethod()][$this->request->getUri()->getPath()] ?? null;
        if (!$callback) {
            echo 'callback is null';
            return null;
        }

        if (is_string($callback)) {
            return $callback;
        }

        if (is_array($callback)) {
            if (isset($callback['class'])) {
                $class = new $callback['class'];
                var_dump(get_class($class));
            } else {
                $class = new $callback[0];
                var_dump(get_class($class));
            }
            return '';
        }

        return call_user_func($callback, $this->request, $this->response);

    }
}
