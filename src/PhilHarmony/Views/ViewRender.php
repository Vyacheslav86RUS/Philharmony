<?php

namespace PhilHarmony\Views;

abstract class ViewRender extends ViewsInterface
{
    public function render(View $view, string $file, $params = []): string
    {
        return '';
    }
}
