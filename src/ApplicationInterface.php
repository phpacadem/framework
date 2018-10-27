<?php
/**
 * User: ivan
 * Date: 27.10.18
 * Time: 16:40
 */

namespace PhpAcadem\framework;

use League\Route\Middleware\MiddlewareAwareInterface;
use League\Route\Route;
use PhpAcadem\framework\view\ViewEngineInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

interface ApplicationInterface
{
    /**
     * @param ServerRequestInterface $request
     */
    public function setRequest(ServerRequestInterface $request);

    /**
     * @param ViewEngineInterface $view
     */
    public function setView(ViewEngineInterface $view): void;

    public function handle(): ResponseInterface;

    /**
     * {@inheritdoc}
     */
    public function middleware(MiddlewareInterface $middleware): MiddlewareAwareInterface;

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