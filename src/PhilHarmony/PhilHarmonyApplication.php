<?php

namespace PhilHarmony;

use PhilHarmony\Http\Request;
use PhilHarmony\Http\Response;
use PhilHarmony\Http\Uri;
use PhilHarmony\Http\Url;
use PhilHarmony\Routing\Route;
use PhilHarmony\Routing\Router;
use PhilHarmony\DependencyInjection\Container;
use ReflectionObject;

class PhilHarmonyApplication
{
    /**
     * @var string
     */
    private $projectDir;

    /**
     * @var Route
     */
    private $route;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @var Container
     */
    private static $container;

    public function __construct()
    {
        $this->initContainer();
    }

    public function initContainer(): void
    {
        self::$container = new Container();
        self::$container->set(
            Uri::class,
            ['url' => Url::createUrl()]
        );
        self::$container->set(
            Request::class,
            [
                'method' => $_SERVER['REQUEST_METHOD'],
                'uri' => self::$container->get(Uri::class)
            ]
        );
        self::$container->set(Response::class);
        self::$container->set(
            Route::class,
            [
                'request' => self::$container->get(Request::class),
                'response' => self::$container->get(Response::class)
            ]
        );
    }

    public function run(): void
    {
        $route = self::$container->get(Route::class);
        $route->get('/h', function () {
            return 'Home page';
        });
        $route->get('/a', ['class' => Router::class]);
        $route->get('/t', 'Test page');
        $route->get('/aa', [Response::class]);

        echo $route->resolve();
//        foreach ($_SERVER as $key => $value) {
//            echo '[' . $key . ']' . ' => ' . $value . '<br>';
//        }

        //echo 'server method ' . $request->getMethod();
        //echo PHP_EOL;
        //var_dump($_SERVER['argv']);
        //echo PHP_EOL;
        //$json_str = file_get_contents('php://input');
        //
        //# Получить объект
        //$json_obj = json_decode($json_str);
        //
        //var_dump($json_obj);

//        $url = Url::createUrl();
//        $uri = $this->getUri($url);
//        echo 'url: ' . $uri . '<br>';
//        //$request = $this->getRequest();
//        if ($_POST) {
//            echo 'POST: <br>';
//            foreach ($_POST as $key => $value) {
//                echo '[' . $key . '] => ' . $value . '<br>';
//            }
//        } else {
//            $rawBody = file_get_contents('php://input');
//            var_dump(json_decode($rawBody, true));
//        }
    }

    public function getProjectDir(): string
    {
        if (!$this->projectDir) {
            $r = new ReflectionObject($this);

            if (!is_file($dir = $r->getFileName())) {
                throw new \LogicException(sprintf('Cannot auto-detect project dir for kernel of class "%s".', $r->name));
            }

            $dir = dirname($dir);
            while (!is_file($dir.'/composer.json')) {
                $dir = dirname($dir);
            }
            $this->projectDir = $dir;
        }

        return $this->projectDir;
    }
}
