<?php

namespace PhpAcadem\framework;


use League\Route\Route;
use PhpAcadem\framework\route\Router;
use PhpAcadem\framework\view\ViewEngineInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class Application implements ApplicationInterface
{
    /** @var  ServerRequestInterface */
    protected $request;
    /** @var ViewEngineInterface */
    protected $view;
    /** @var Router */
    protected $router;

    /**
     * Application constructor.
     * @param ServerRequestInterface $request
     * @param ViewEngineInterface $view
     * @param Router $router
     */
    public function __construct(ServerRequestInterface $request, ViewEngineInterface $view, Router $router)
    {
        $this->request = $request;
        $this->view = $view;
        $this->router = $router;
    }

    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface
    {
        return $this->request;
    }

    /**
     * @return Router
     */
    public function getRouter(): Router
    {
        return $this->router;
    }

    /**
     * @return ViewEngineInterface
     */
    public function getView(): ViewEngineInterface
    {
        return $this->view;
    }

    public function handle(): ResponseInterface
    {
        return $this->router->dispatch($this->request);
    }

    /**
     * {@inheritdoc}
     */
    public function middleware(MiddlewareInterface $middleware): ApplicationInterface
    {
        $this->router->middleware($middleware);
        return $this;
    }

    /**
     * Add a route that responds to GET HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function get($path, $handler)
    {
        return $this->router->get($path, $handler);
    }

    /**
     * Add a route that responds to POST HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function post($path, $handler)
    {
        return $this->router->post($path, $handler);
    }

    /**
     * Add a route that responds to PUT HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function put($path, $handler)
    {
        return $this->router->put($path, $handler);
    }

    /**
     * Add a route that responds to PATCH HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function patch($path, $handler)
    {
        return $this->router->patch($path, $handler);
    }

    /**
     * Add a route that responds to DELETE HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function delete($path, $handler)
    {
        return $this->router->delete($path, $handler);
    }
}