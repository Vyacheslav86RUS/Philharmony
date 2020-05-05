<?php

namespace PhilHarmony;

use PhilHarmony\Http\Request;
use PhilHarmony\Http\Uri;
use PhilHarmony\Http\Url;

class PhilHarmonyApplication
{
    public function run(): void
    {
        foreach ($_SERVER as $key => $value) {
            echo '[' . $key . ']' . ' => ' . $value . PHP_EOL;
        }

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

        $url = Url::createUrl();
        $uri = $this->getUri($url);
        echo $uri;
        //$request = $this->getRequest();
        var_dump($_POST);
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
