<?php


namespace PhpAcadem\framework\route;

use FastRoute\Dispatcher as FastRoute;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Dispatcher extends \League\Route\Dispatcher
{
    /**
     * Dispatch the current route
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function dispatchRequest(ServerRequestInterface $request): ResponseInterface
    {
        $match = $this->dispatch($request->getMethod(), $request->getUri()->getPath());

        switch ($match[0]) {
            case FastRoute::NOT_FOUND:
                $this->setNotFoundDecoratorMiddleware();
                break;
            case FastRoute::METHOD_NOT_ALLOWED:
                $allowed = (array)$match[1];
                $this->setMethodNotAllowedDecoratorMiddleware($allowed);
                break;
            case FastRoute::FOUND:
                $match[1]->setVars($match[2]);
                $this->setFoundMiddleware($match[1]);
                $request = $request->withAttribute('route', $match[1]);
                break;
        }

        return $this->handle($request);
    }
}