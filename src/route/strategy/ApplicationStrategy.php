<?php

namespace PhpAcadem\framework\route\strategy;


use League\Route\Http\Exception\MethodNotAllowedException;
use League\Route\Http\Exception\NotFoundException;
use PhpAcadem\framework\middleware\ErrorHandlerMiddleware;
use Psr\Http\Server\MiddlewareInterface;

class ApplicationStrategy extends \League\Route\Strategy\ApplicationStrategy
{

    /**
     * {@inheritdoc}
     */
    public function getNotFoundDecorator(NotFoundException $exception): MiddlewareInterface
    {
        return $this->throwThrowableMiddleware($exception);
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

    protected function getErrorHandlerMiddleware()
    {
        return $this->container->has(\PhpAcadem\framework\middleware\ErrorHandlerMiddlewareInterface::class)
            ? $this->container->get(\PhpAcadem\framework\middleware\ErrorHandlerMiddlewareInterface::class)
            : new ErrorHandlerMiddleware();
    }

    protected function throwThrowableMiddleware(\Throwable $error): MiddlewareInterface
    {
        $errorHandlerMiddleware = $this->getErrorHandlerMiddleware();
        $errorHandlerMiddleware->setException($error);
        return $errorHandlerMiddleware;
    }
}