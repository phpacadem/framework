<?php

namespace PhpAcadem\framework;


use PhpAcadem\framework\route\Router;
use PhpAcadem\framework\view\ViewEngineInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application extends Router
{
    /** @var  ServerRequestInterface */
    protected $request;
    /** @var ViewEngineInterface */
    protected $view;

    /**
     * @param ServerRequestInterface $request
     */
    public function setRequest(ServerRequestInterface $request)
    {
        $this->request = $request;
    }

    /**
     * @return ViewEngineInterface
     */
    public function getView(): ViewEngineInterface
    {
        return $this->view;
    }

    /**
     * @param ViewEngineInterface $view
     */
    public function setView(ViewEngineInterface $view): void
    {
        $this->view = $view;
    }

    public function handle(): ResponseInterface
    {
        return $this->dispatch($this->request);
    }

}