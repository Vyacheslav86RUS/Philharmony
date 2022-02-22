<?php

namespace DependencyInjection\Arguments;

use PhilHarmony\DependencyInjection\Arguments\Singleton;
use PHPUnit\Framework\TestCase;

class SingletonsTest extends TestCase
{
    private const NAME = 'Test';

    /**
     * @var Singleton
     */
    private $singletons;

    protected function setUp(): void
    {
        parent::setUp();
        $this->singletons = new Singleton();
        $this->singletons->setSingletons(self::NAME);
        $this->assertInstanceOf(Singleton::class, $this->singletons);
    }

    public function testSetSingletons()
    {
        $this->assertEquals(self::NAME, $this->singletons->getSingletons());
    }

    public function testGetSingletons()
    {
        $this->assertEquals(self::NAME, $this->singletons->getSingletons());
    }
}
