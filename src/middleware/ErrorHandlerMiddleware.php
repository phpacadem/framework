<?php

namespace PhpAcadem\framework\middleware;

use League\Plates\Engine;
use League\Route\Http\Exception\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Whoops\Run;
use Zend\Diactoros\Response\HtmlResponse;

class ErrorHandlerMiddleware implements MiddlewareInterface
{
    protected $debug = false;
    protected $whoops = null;
    protected $view = null;

    /**
     * ErrorHandlerMiddleware constructor.
     * @param bool $debug
     */
    public function __construct(Engine $view, bool $debug = false, Run $whoops = null)
    {
        $this->debug = $debug;
        $this->whoops = $whoops;
        $this->view = $view;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        try {
            $response = $handler->handle($request);
        } catch (\Throwable $e) {
            if ($e instanceof NotFoundException) {
                throw $e;
            }
            if ($this->debug) {
                $whoops->handleException($e);
            } else {
                return new HtmlResponse($this->view->render('error/500.phtml', [
                    'request' => $request,
                ]), 500);
            }
        }


        return $response;
    }

}