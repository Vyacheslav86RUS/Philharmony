<?php

namespace PhilHarmony;

use PhilHarmony\Http\Request;
use PhilHarmony\Http\Response;
use PhilHarmony\Http\Uri;
use PhilHarmony\Http\Url;
use PhilHarmony\Routing\Route;
use PhilHarmony\Routing\Router;
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

    public function __construct()
    {
        $url = Url::createUrl();
        $uri = new Uri($url);
        $this->request = new Request($_SERVER['REQUEST_METHOD'], $uri);
        $this->response = new Response();
        $this->route = new Route($this->request, $this->response);
    }

    public function run(): void
    {
        $this->route->get('/h', function () {
            return 'Home page';
        });
        $this->route->get('/a', ['class' => Router::class]);
        $this->route->get('/t', 'Test page');
        $this->route->get('/aa', [Response::class]);
        //$this->route->post('/text', '');

        echo $this->route->resolve();
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

    public function getRequest(): Request
    {
        return new Request();
    }

    public function getUri(string $url): Uri
    {
        return new Uri($url);
    }
}
