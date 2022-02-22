<?php

namespace PhilHarmony\DependencyInjection;

use PhilHarmony\DependencyInjection\Arguments\Definition;
use PhilHarmony\DependencyInjection\Arguments\Instance;
use PhilHarmony\DependencyInjection\Arguments\Parameter;
use PhilHarmony\DependencyInjection\Arguments\Singleton;
use PhilHarmony\DependencyInjection\Exception\PhilHarmonyContainerException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class Container implements ContainerInterface
{
    private $container = [];
    private $definition = [];
    private $instances = [];
    private $parameters = [];
    /**
     * @var Singleton
     */
    private $singletons;

    public function get(string $id): object
    {
        if ($this->hasSingleton($id)) {
            return $this->singletons->getSingletons($id);
        }

        if (!$this->has($id)) {
            throw new PhilHarmonyContainerException('not found ' . $id);
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

    /**
     * @param string $id
     * @return bool
     */
    public function hasSingleton(string $id): bool
    {
        return $this->singletons->has($id);
    }

    /**
     * @param string $class
     * @param string|null $definition
     * @param array $parameters
     * @return $this
     */
    public function set(string $class, ?string $definition = null, array $parameters = [])
    {
        $this->setDefinitions($class, $definition, $parameters);
        if ($this->hasSingleton($class)) {
            unset($this->singletons[$class]);
        }

        return $this;
    }

    public function setSingleton(string $class, ?string $definition = null, array $parameters = [])
    {
        $this->setDefinitions($class, $definition, $parameters);
        $this->singletons->setSingletons($class, $this->build($class));

        return $this;
    }

    private function setDefinitions(string $class, ?string $definition = null, array $parameters = [])
    {
        if (!class_exists($class)) {
            throw new PhilHarmonyContainerException('Not found ' . $class);
        }

        $this->container[$class] = $class;
        $this->definition[$class] = $definition;
        $this->parameters[$class] = $parameters;
    }

    private function build(string $class): object
    {
        $reflection = new \ReflectionClass($this->container[$class]);

        if (!$reflection->isInstantiable()) {
            throw new PhilHarmonyContainerException('Class ' . $this->container[$class] . 'is not instantiable');
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
        foreach ($parameters as $index => $parameter) {
            $dependency = $parameter->getClass();
            if ($dependency === null) {
                $classArg = $this->parameters[$class];
                if (isset($classArg[$parameter->name])) {
                    $dependencies[] = $classArg[$parameter->name];
                } elseif (array_key_exists($index, $classArg)){
                    $dependencies[] = $classArg[$index];
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
