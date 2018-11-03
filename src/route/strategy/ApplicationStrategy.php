<?php

namespace PhpAcadem\framework\route\strategy;


use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use League\Route\Route;
use PhpAcadem\framework\middleware\ErrorHandlerMiddleware;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

class ApplicationStrategy extends \League\Route\Strategy\ApplicationStrategy
{

    public function invokeRouteCallable(Route $route, ServerRequestInterface $request): ResponseInterface
    {

        $controller = $route->getCallable($this->getContainer());
        if (isset($controller[0]) && method_exists($controller[0], 'init')) {
            $controller[0]->init($request);
        }

        $response = $controller($request, $route->getVars());
        $response = $this->applyDefaultResponseHeaders($response);

        return $response;
    }

    /**
     * {@inheritdoc}
     */
    public function getNotFoundDecorator(NotFoundException $exception): MiddlewareInterface
    {
        return $this->throwThrowableMiddleware($exception);
    }

    protected function throwThrowableMiddleware(\Throwable $error): MiddlewareInterface
    {
        $errorHandlerMiddleware = $this->getErrorHandlerMiddleware();
        $errorHandlerMiddleware->setException($error);
        return $errorHandlerMiddleware;
    }

    protected function getErrorHandlerMiddleware()
    {
        return $this->container->has(\PhpAcadem\framework\middleware\ErrorHandlerMiddlewareInterface::class)
            ? $this->container->get(\PhpAcadem\framework\middleware\ErrorHandlerMiddlewareInterface::class)
            : new ErrorHandlerMiddleware();
    }

    /**
     * {@inheritdoc}
     */
    public function getMethodNotAllowedDecorator(MethodNotAllowedException $exception): MiddlewareInterface
    {
        return $this->throwThrowableMiddleware($exception);
    }

    /**
     * {@inheritdoc}
     */
    public function getThrowableHandler(): MiddlewareInterface
    {
        $errorHandlerMiddleware = $this->getErrorHandlerMiddleware();
        return $errorHandlerMiddleware;
    }

    /**
     * {@inheritdoc}
     */
    public function getExceptionHandler(): MiddlewareInterface
    {
        $errorHandlerMiddleware = $this->getErrorHandlerMiddleware();
        return $errorHandlerMiddleware;
    }
}