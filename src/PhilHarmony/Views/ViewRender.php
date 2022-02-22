<?php

namespace PhilHarmony\Views;

abstract class ViewRender implements ViewRenderInterface
{
    public function render(View $view, string $file, array $params = []): string
    {
        return '';
    }
}
