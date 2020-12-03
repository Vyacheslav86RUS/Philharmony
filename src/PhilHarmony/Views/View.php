<?php

namespace PhilHarmony\Views;

class View
{
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var ViewRender
     */
    private $render;

    public function render(string $viewName, array $params = []): string
    {
        return '';
    }
}
