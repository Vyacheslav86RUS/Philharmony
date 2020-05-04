<?php

namespace tests\Routing;

use PhilHarmony\Routing\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /**
     * @var Route
     */
    private $route;

    protected function setUp(): void
    {
        parent::setUp();
        $this->route = new Route();
    }

    /**
     * @dataProvider addRouteDataProvider
     *
     * @param string $method
     * @param string $url
     * @param array $params
     */
    public function testAddRoute(string $method, string $url, array $params): void
    {
        $route = $this->route->addRoute($method, $url, $params);
        $this->assertInstanceOf(Route::class, $route);
        $this->assertEquals($route->method, $method);
        $this->assertEquals($route->url, $url);
        $this->assertEquals($route->params, $params);
    }

    /**
     * @return array
     */
    public function addRouteDataProvider(): array
    {
        return [
            [
                'method' => 'GET',
                'url' => '/',
                'params' => []
            ],
            [
                'method' => 'POST',
                'url' => '/user/create',
                'params' => [
                    'name' => 'Test',
                    'phone' => '79608847955',
                    'email' => 'test@test.com'
                ]
            ],
            [
                'method' => 'PUT',
                'url' => '/user/{id}/update',
                'params' => [
                    'id' => 1,
                    'name' => 'Test2'
                ]
            ]
        ];
    }
}
