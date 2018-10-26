<?php

namespace PhpAcadem\framework\controller;


use League\Route\Http\Exception\HttpExceptionInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class DefaultErrorController extends ControllerAbstract
{
    public function indexAction(ServerRequestInterface $request): ResponseInterface
    {
        $e = $request->getAttribute('exception');

        try {
            if ($e instanceof HttpExceptionInterface) {
                return $this->render('error/' . $e->getStatusCode(), ['e' => $e], $e->getStatusCode());
            }
        } catch (\Throwable $errorControllerException) {
            $statusCode = 500;
        }
        $statusCode = $statusCode ?? $e->getCode();
        return $this->render('error/500', ['e' => $e], $statusCode);
    }
}