<?php

namespace Configurations;

use PhilHarmony\Configurations\Configuration;
use Codeception\PHPUnit\TestCase;

class ConfigurationTest extends TestCase
{
    /**
     * @dataProvider getConfiguration
     *
     * @param array $config
     */
    public function testGetConfiguration(array $config): void
    {
        $configuration = new Configuration($config);

        if (empty($config)) {
            $this->assertEmpty($configuration->getConfiguration());
        } else {
            $this->assertNotEmpty($configuration->getConfiguration());
        }
    }

    public function getConfiguration(): array
    {
        return [
            [
                'config' => []
            ],
            [
                'config' => [
                    'classes' => [],
                    'params' => []
                ]
            ]
        ];
    }
}
