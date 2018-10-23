<?php

namespace PhpAcadem\framework\controller;


use PhpAcadem\framework\container\ContainerAwareTrait;
use League\Plates\Engine;


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


    protected function render($templateName, $data = [])
    {
        return new \Zend\Diactoros\Response\HtmlResponse($this->view->render($templateName, $data));
    }
}