<?php

namespace PhilHarmony\Configurations;

class Configuration
{
    public const CONFIGURATION_PARAMS = 'params';

    private $configuration;

    public function __construct(array $config = [])
    {
        $this->configuration = $config;
    }

    public function getConfiguration(): array
    {
        return $this->configuration;
    }

    public function getConfigurationByName(string $name)
    {
        return $this->configuration[$name] ?? null;
    }

    public function getConfigurationParams(): array
    {
        return $this->configuration[self::CONFIGURATION_PARAMS] ?? [];
    }
}
