<?php

namespace PhilHarmony;

use PhilHarmony\Http\Request\Request;
use PhilHarmony\Http\Response\Response;
use PhilHarmony\Http\Uri;
use PhilHarmony\Http\Url;
use PhilHarmony\Routing\Route;
use PhilHarmony\Routing\Router;
use PhilHarmony\DependencyInjection\Container;
use PhilHarmony\Routing\RouterCollection;
use PhilHarmony\Views\PhpFileRender;
use PhilHarmony\Views\View;
use ReflectionObject;

class PhilHarmonyApplication
{
    /**
     * @var string
     */
    public static $ROOT_DIR;

    /**
     * @var Container
     */
    public static $container;

    public function __construct()
    {
       $this->initRootProjectDirectory();
       PhilHarmonyBootstrap::bootstrap();
    }

    public function run(): void
    {
        $route = self::$container->get(Route::class);
        $route->get('/', function () {
            return 'Home page';
        });
        $route->get('/a', ['class' => Router::class]);
        $route->get('/route', 'Test page');
        $route->get('/about', [__CLASS__]);
        $route->get('/dir', function () {
            return self::$ROOT_DIR;
        });
        $route->get('/view', ['class' => self::$container->get(View::class)]);
//        $route->get('/view', function () {
////            $view = self::$container->get(View::class);
////            return $view->render();
//            $render = new PhpFileRender();
//            return $render->render();
//        });

        echo $route->resolve();
//        $containerBuilder = new ContainerBuilder();
//        $containerBuilder->register();
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

    private function initRootProjectDirectory(): void
    {
        if (!self::$ROOT_DIR) {
            $r = new ReflectionObject($this);

            if (!is_file($dir = $r->getFileName())) {
                throw new \LogicException(sprintf('Cannot auto-detect project dir for kernel of class "%s".', $r->name));
            }

            $dir = dirname($dir);
            while (!is_file($dir.'/composer.json')) {
                $dir = dirname($dir);
            }
            self::$ROOT_DIR = $dir;
        }
    }
}
