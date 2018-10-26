<?php

namespace PhpAcadem\framework\controller;


use League\Plates\Engine;
use PhpAcadem\framework\container\ContainerAwareTrait;


class ControllerAbstract
{
    use ContainerAwareTrait;

    /**
     * @var Engine
     */
    protected $view;


    /**
     * ControllerAbstract constructor.
     */
    public function init()
    {
        $this->view = $this->container->get(Engine::class);
    }

    /**
     * @param Engine $view
     */
    public function setView(Engine $view): void
    {
        $this->view = $view;
    }


    protected function render($templateName, $data = [], $status = 200, $headers = [])
    {
        return new \Zend\Diactoros\Response\HtmlResponse($this->view->render($templateName, $data), $status, $headers);
    }
}