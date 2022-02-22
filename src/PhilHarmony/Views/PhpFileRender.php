<?php

namespace PhilHarmony\Views;

use thecodeholic\phpmvc\Application;

class PhpFileRender implements ViewRenderInterface
{
    private $defaultLayout = '/Users/slavaveremeevskii/PhpstormProjects/Philharmony/views/layout/layout.php';

    public function render(string $view, array $params = []): string
    {
        $viewContent = $this->renderViewOnly($view, $params);
        ob_start();
        include_once $this->defaultLayout;
        $layoutContent = ob_get_clean();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderViewOnly($view, array $params)
    {
        foreach ($params as $key => $value) {
            $$key = $value;
        }
        ob_start();
        include_once Application::$ROOT_DIR."/views/$view.php";
        return ob_get_clean();
    }
}