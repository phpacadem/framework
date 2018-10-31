<?php
/**
 * User: ivan
 * Date: 27.10.18
 * Time: 16:40
 */

namespace PhpAcadem\framework;

use League\Route\Route;
use PhpAcadem\framework\route\Router;
use PhpAcadem\framework\view\ViewEngineInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

interface ApplicationInterface
{
    /**
     * @return ServerRequestInterface
     */
    public function getRequest(): ServerRequestInterface;

    /**
     * @return Router
     */
    public function getRouter(): Router;

    /**
     * @return ViewEngineInterface
     */
    public function getView(): ViewEngineInterface;

    /**
     * @return ResponseInterface
     */
    public function handle(): ResponseInterface;

    /**
     * {@inheritdoc}
     */
    public function middleware(MiddlewareInterface $middleware): ApplicationInterface;

    /**
     * Add a route that responds to GET HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function get($path, $handler);

    /**
     * Add a route that responds to POST HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function post($path, $handler);

    /**
     * Add a route that responds to PUT HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function put($path, $handler);

    /**
     * Add a route that responds to PATCH HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function patch($path, $handler);

    /**
     * Add a route that responds to DELETE HTTP method.
     *
     * @param string $path
     * @param callable|string $handler
     *
     * @return Route
     */
    public function delete($path, $handler);

}