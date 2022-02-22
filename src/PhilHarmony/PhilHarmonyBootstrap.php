<?php

namespace PhilHarmony;

use PhilHarmony\DependencyInjection\Container;
use PhilHarmony\Http\Request\Request;
use PhilHarmony\Http\Response\Response;
use PhilHarmony\Http\Uri;
use PhilHarmony\Http\Url;
use PhilHarmony\Routing\Route;
use PhilHarmony\Routing\RouterCollection;
use PhilHarmony\Views\PhpFileRender;
use PhilHarmony\Views\View;
use PhilHarmony\Views\ViewRenderInterface;

class PhilHarmonyBootstrap
{
    public static function bootstrap(): void
    {
        if (!PhilHarmonyApplication::$container) {
            PhilHarmonyApplication::$container = new Container();
            PhilHarmonyApplication::$container->set(
                Uri::class,
                Uri::class,
                ['url' => Url::createUrl()]
            );
            PhilHarmonyApplication::$container->set(
                Request::class,
                Request::class,
                [
                    'method' => $_SERVER['REQUEST_METHOD'],
                    'uri' => PhilHarmonyApplication::$container->get(Uri::class)
                ]
            );
            PhilHarmonyApplication::$container->setSingleton(RouterCollection::class);
            PhilHarmonyApplication::$container->set(Response::class);
            PhilHarmonyApplication::$container->set(Route::class);

            PhilHarmonyApplication::$container->set(
                View::class,
                View::class,
                [
                    PhpFileRender::class
                ]
            );
        }
    }
}
