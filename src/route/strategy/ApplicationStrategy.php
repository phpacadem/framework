<?php

namespace PhpAcadem\framework\route\strategy;


use PhpAcadem\framework\middleware\ErrorHandlerMiddleware;
use Psr\Http\Server\MiddlewareInterface;

class ApplicationStrategy extends \League\Route\Strategy\ApplicationStrategy
{

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

    /**
     * {@inheritdoc}
     */
    public function getThrowableHandler(): MiddlewareInterface
    {
        $errorHandlerMiddleware = $this->getErrorHandlerMiddleware();
        return $errorHandlerMiddleware;
    }
}