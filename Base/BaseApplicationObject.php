<?php

namespace PhilHarmony\Base;


class BaseApplicationObject
{
    public function __construct()
    {
    }

    public function __get($name)
    {
        $getter = 'get' . $name;

        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        throw new \RuntimeException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __set($name, $value)
    {
        $setter = 'set' . $name;

        if (!method_exists($this, $setter)) {
            throw new \RuntimeException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }

        $this->$setter($value);
    }

    public function __isset($name)
    {
        $getter = 'get' . $name;

        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }

        return false;
    }

    public function __unset($name)
    {
        $setter = 'set' . $name;

        if (method_exists($this, $setter)) {
            $this->$setter(null);
        }

        throw new \RuntimeException('Unsetting property: ' . get_class($this) . '::' . $name);
    }

    public function __call($name, $arguments)
    {
        throw new \RuntimeException(
            'Unknow method: ' . get_class($this) . '->' . $name . '(' . implode(',', $arguments) . ')'
        );
    }

    public static function __callStatic($name, $arguments)
    {
        throw new \RuntimeException(
            'Unknow method: ' . get_called_class() . '::' . $name . '(' . implode(',', $arguments) . ')'
        );
    }
}