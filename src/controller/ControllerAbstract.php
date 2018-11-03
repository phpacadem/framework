<?php

namespace PhpAcadem\framework\controller;


use PhpAcadem\framework\container\ContainerAwareTrait;
use PhpAcadem\framework\route\UrlInterface;
use PhpAcadem\framework\view\ViewEngineInterface;
use Psr\Http\Message\ServerRequestInterface;


class ControllerAbstract
{
    use ContainerAwareTrait;

    /**
     * @var ViewEngineInterface
     */
    protected $view;

    /** @var UrlInterface */
    protected $url;

    /** @var  ServerRequestInterface */
    protected $request;


    /**
     * ControllerAbstract constructor.
     * @param ServerRequestInterface $request
     */
    public function init(ServerRequestInterface $request)
    {
        $this->view = $this->container->get(ViewEngineInterface::class);
        $this->url = $this->container->get(UrlInterface::class);
        $this->request = $request;
    }

    /**
     * @param ViewEngineInterface $view
     */
    public function setView(ViewEngineInterface $view): void
    {
        $this->view = $view;
    }


    protected function render($templateName, $data = [], $status = 200, $headers = [])
    {
        $layoutData = $this->request->getAttribute('layoutData') ?? [];
        $data = array_merge($layoutData, $data);
        return new \Zend\Diactoros\Response\HtmlResponse($this->view->render($templateName, $data), $status, $headers);
    }
}