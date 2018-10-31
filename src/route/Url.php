<?php

namespace PhpAcadem\framework\route;


class Url implements UrlInterface
{
    /** @var \League\Route\RouteCollectionInterface */
    protected $router;
    /** @var \FastRoute\RouteParser\Std */
    protected $parser;

    /**
     * Url constructor.
     * @param \League\Route\Router $router
     */
    public function __construct(\League\Route\Router $router, \FastRoute\RouteParser\Std $parser)
    {
        $this->router = $router;
        $this->parser = $parser;
    }

    public function get($routeName, $params = [])
    {
        $route = $this->router->getNamedRoute($routeName);

        $routes = $this->parser->parse($route->getPath())[0];
        $url = '';
        foreach ($routes as $part) {

            if (is_string($part)) {
                $url .= $part;
                continue;
            }

            if (is_array($part)) {
                if (array_key_exists($part[0], $params)) {
                    $url .= $params[$part[0]];
                }
            }
        }
        return $url;
    }
}