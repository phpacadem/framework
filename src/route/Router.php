<?php

namespace PhpAcadem\framework\route;


use PhpAcadem\framework\route\strategy\ApplicationStrategy;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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

    /**
     * {@inheritdoc}
     */
    public function dispatch(ServerRequestInterface $request): ResponseInterface
    {
        if (is_null($this->getStrategy())) {
            $this->setStrategy(new ApplicationStrategy());
        }

        $this->prepRoutes($request);

        return (new Dispatcher($this->getData()))
            ->middlewares($this->getMiddlewareStack())
            ->setStrategy($this->getStrategy())
            ->dispatchRequest($request);
    }
}