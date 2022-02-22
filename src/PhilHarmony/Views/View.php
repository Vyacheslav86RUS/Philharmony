<?php

namespace PhilHarmony\Views;

class View
{
    /**
     * @var string
     */
    private $viewPath;

    /**
     * @var ViewRenderInterface
     */
    private $render;

    public function __construct(ViewRenderInterface $render)
    {
        $this->render = $render;
    }

    public function render(string $viewName, array $params = []): string
    {
       return $this->render->render($viewName, $params);
    }
}
