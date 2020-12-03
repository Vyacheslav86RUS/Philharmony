<?php

namespace PhilHarmony\Routing;

use PhilHarmony\Http\HttpMethod;
use PhilHarmony\PhilHarmonyObject;

abstract class BaseRoute extends PhilHarmonyObject
{
    /**
     * @param string $method
     * @param string $url
     * @param string|callable|array|null $callable
     * @return mixed
     */
    abstract public function addRoute(string $method, string $url, $callable);

    /**
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function get(string $url, $callable): self
    {
        return $this->addRoute(HttpMethod::GET, $url, $callable);
    }

    /**
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function post(string $url, $callable): self
    {
        return $this->addRoute(HttpMethod::POST, $url, $callable);
    }

    /**
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function put(string $url, $callable): self
    {
        return $this->addRoute(HttpMethod::PUT, $url, $callable);
    }

    /**
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function patch(string $url, $callable): self
    {
        return $this->addRoute(HttpMethod::PATCH, $url, $callable);
    }

    /**
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function head(string $url, $callable): self
    {
        return $this->addRoute(HttpMethod::HEAD, $url, $callable);
    }

    /**
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function options(string $url, $callable = ''): self
    {
        return $this->addRoute(HttpMethod::OPTIONS, $url, $callable);
    }

    /**
     * @param string $url
     * @param string|callable|array|null $callable
     * @return $this
     */
    public function delete(string $url, $callable = ''): self
    {
        return $this->addRoute(HttpMethod::DELETE, $url, $callable);
    }
}
