<?php

namespace PhpAcadem\framework\route;


class Router extends \League\Route\Router
{
    /**
     * {@inheritdoc}
     */
    public function map(string $method, string $path, $handler): \League\Route\Route
    {
        $path = sprintf('/%s', ltrim($path, '/'));
        $route = new Route($method, $path, $handler);

        $this->routes[] = $route;

        return $route;
    }
}