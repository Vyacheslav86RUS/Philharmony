<?php

namespace PhilHarmony\Views;

interface ViewRenderInterface
{
    public function render(View $view, string $file, array $params = []): string;
}
