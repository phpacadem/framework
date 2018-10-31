<?php

namespace PhpAcadem\framework\middleware;

use League\Route\Dispatcher;
use League\Route\Http\Exception;
use PhpAcadem\framework\route\Route;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Whoops\Run;

class ErrorHandlerMiddleware implements ErrorHandlerMiddlewareInterface
{
    protected const DEFAULT_ERROR_HANDLER = 'PhpAcadem\framework\controller\DefaultErrorController::indexAction';
    protected $debug = false;
    protected $whoops = null;
    protected $errorHandler = '';

    protected $httpClientErrorCodes = [
        '400',
        '401',
        '402',
        '403',
        '404',
        '405',
        '406',
        '407',
        '408',
        '409',
        '410',
        '411',
        '412',
        '413',
        '414',
        '415',
        '416',
        '417',
        '418',
        '421',
        '422',
        '423',
        '424',
        '426',
        '428',
        '429',
        '431',
        '449',
        '451',
    ];
    protected $httpRedirectCodes = [

    ];

    /** @var \Throwable */
    protected $exception = null;

    /**
     * @param \Throwable $exception
     */
    public function setException(\Throwable $exception): void
    {
        $this->exception = $exception;
    }

    /**
     * ErrorHandlerMiddleware constructor.
     * @param string $errorHandler
     * @param bool $debug
     * @param Run|null $whoops
     */
    public function __construct($errorHandler = '', bool $debug = false, Run $whoops = null)
    {
        $this->debug = $debug;
        $this->whoops = $whoops;
        $this->errorHandler = $errorHandler ?: self::DEFAULT_ERROR_HANDLER;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     * @throws \Throwable
     */
    protected function handle(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        if ($this->exception instanceof \Throwable) {
            throw $this->exception;
        }
        return $handler->handle($request);
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $whoops = $this->whoops ?? new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        try {
            try {

                $response = $this->handle($request, $handler);

            } catch (Exception $e) {

                if (in_array($e->getStatusCode(), $this->httpClientErrorCodes)) {
                    return $this->forward($e, $request, $handler);
                }
                throw $e;

            } catch (\Exception $e) {

                if (in_array($e->getCode(), $this->httpClientErrorCodes)) {
                    $httpException = new Exception($e->getCode(), $e->getMessage(), $e);
                    return $this->forward($httpException, $request, $handler);
                }
                throw $e;

            }
        } catch (\Throwable $e) {

            if ($this->debug) {
                $whoops->handleException($e);
            } else {
                return $this->forward($e, $request, $handler);
            }
        }


        return $response;
    }

    protected function forward($e, ServerRequestInterface $request, RequestHandlerInterface $handler)
    {
        if ($handler instanceof Dispatcher) {
            return (new \PhpAcadem\framework\route\Dispatcher([[], []]))
                ->middleware((new Route('', '', $this->errorHandler))->setStrategy($handler->getStrategy()))
                ->setStrategy($handler->getStrategy())
                ->handle($request->withAttribute('exception', $e));
        }
    }

}