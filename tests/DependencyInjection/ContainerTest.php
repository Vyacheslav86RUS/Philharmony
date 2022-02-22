<?php

namespace DependencyInjection;

use PhilHarmony\DependencyInjection\Container;
use PhilHarmony\Http\Request\Request;
use PhilHarmony\Http\Uri;
use PhilHarmony\Http\Url;
use PhilHarmony\Views\PhpFileRender;
use PhilHarmony\Views\View;
use PHPUnit\Framework\TestCase;

class ContainerTest extends TestCase
{
    /**
     * @var Container
     */
    private $container;

    protected function setUp(): void
    {
        parent::setUp();

        $this->container = new Container();
    }

    public function testSetSingleton()
    {
        $this->container->setSingleton(Request::class, Request::class, ['get', 'loacal', [], 'test']);
        $request = $this->container->get(Request::class);
        $this->assertInstanceOf(Request::class, $request);
    }

    public function testGet()
    {
        $this->container->set(View::class);
        $view = $this->container->get(View::class);
        var_dump($view);
    }

    public function testSet()
    {
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['REQUEST_URI'] = '/';
        $this->container->set(Uri::class, Uri::class, [Url::createUrl()]);
        $uri = $this->container->get(Uri::class);
        $this->assertInstanceOf(Uri::class, $uri);
    }
}
