<?php

namespace PhilHarmony\Views;

interface ViewRenderInterface
{
    public function render(string $view, array $params = []): string;
}
