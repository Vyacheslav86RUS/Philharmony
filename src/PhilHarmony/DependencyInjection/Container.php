<?php

namespace PhilHarmony\DependencyInjection;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    /**
     * @var array[]
     */
    private $container;

    /**
     * @var array[]
     */
    private $definition;

    /**
     * @var object[]
     */
    private $instances;

    /**
     * @var array[]
     */
    private $parameters;

    /**
     * @param string $id
     * @return object
     */
    public function get($id)
    {
        if (!$this->has($id)) {
            throw new \Exception();
        }

        if (!isset($this->instances[$id])) {
            $this->instances[$id] = $this->build($id);
        }

        return $this->instances[$id];
    }

    public function has($id): bool
    {
        return isset($this->container[$id]);
    }

    public function set(string $class, array $parameters = []): void
    {
        if (!class_exists($class)) {
            throw new \Exception('Not found ' . $class);
        }

        $this->container[$class] = $class;
        $this->parameters[$class] = $parameters;
    }

    private function build(string $class)
    {
        $reflection = new \ReflectionClass($this->container[$class]);

        if (!$reflection->isInstantiable()) {
            throw new \Exception('Class ' . $this->container[$class] . 'is not instantiable');
        }

        $constructor = $reflection->getConstructor();

        if (is_null($constructor)) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters, $class);

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * @param \ReflectionParameter[] $parameters
     * @param string $class
     * @return array
     * @throws \ReflectionException
     */
    private function getDependencies(array $parameters, string $class): array
    {
        $dependencies = [];
        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();
            if ($dependency === null) {
                if (isset($this->parameters[$class][$parameter->name])) {
                    $dependencies[] = $this->parameters[$class][$parameter->name];
                } elseif ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                }
            } else {
                $dependencies[] = $this->get($dependency->name);
            }
        }
        return $dependencies;
    }
}
