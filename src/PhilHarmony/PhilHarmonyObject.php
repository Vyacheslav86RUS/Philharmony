<?php

namespace PhilHarmony;

class PhilHarmonyObject
{
    public function __get($name)
    {
        $getter = 'get' . ucfirst($name);

        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        throw new \RuntimeException('Getting unknown property: ' . get_class($this) . '::' . $name);
    }

    public function __set($name, $value)
    {
        $setter = 'set' . ucfirst($name);

        if (!method_exists($this, $setter)) {
            throw new \RuntimeException('Setting unknown property: ' . get_class($this) . '::' . $name);
        }

        $this->$setter($value);
    }

    public function __isset($name)
    {
        $getter = 'get' . ucfirst($name);

        if (method_exists($this, $getter)) {
            return $this->$getter() !== null;
        }

        return false;
    }

    public function __unset($name)
    {
        $setter = 'set' . ucfirst($name);

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
    public function __clone()
    {
        // TODO: Implement __clone() method.
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
    }

    public function __invoke()
    {
        // TODO: Implement __invoke() method.
    }

    public function __toString()
    {
        return '';
    }
}
