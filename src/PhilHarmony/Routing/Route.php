<?php

namespace PhilHarmony\Routing;

/**
 * Class Route
 * @package PhilHarmony\Routing
 *
 * @property string $method
 * @property string $url
 * @property array $params
 */
class Route extends BaseRoute
{
    public function addRoute(string $method, string $url, array $params = []): self
    {
        $this->method = $method;
        $this->url = $url;
        $this->params = $params;

        return $this;
    }

    public function get(string $url, array $params = []): self
    {
        return $this->addRoute('GET', $url, $params);
    }

    public function post(string $url, array $params = []): self
    {
        return $this->addRoute('POST', $url, $params);
    }

    public function put(string $url, array $params = []): self
    {
        return $this->addRoute('PUT', $url, $params);
    }

    public function head(string $url, array $params = []): self
    {
        return $this->addRoute('HEAD', $url, $params);
    }

    public function options(string $url, array $params = []): self
    {
        return $this->addRoute('OPTIONS', $url, $params);
    }

    public function delete(string $url, array $params = []): self
    {
        return $this->addRoute('DELETE', $url, $params);
    }

    public function path(string $url, array $params = []): self
    {
        return $this->addRoute('PATH', $url, $params);
    }
}
