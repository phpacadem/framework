<?php

namespace PhpAcadem\framework\controller;


use PhpAcadem\framework\container\ContainerAwareTrait;
use PhpAcadem\framework\view\ViewEngineInterface;


class ControllerAbstract
{
    use ContainerAwareTrait;

    /**
     * @var ViewEngineInterface
     */
    protected $view;


    /**
     * ControllerAbstract constructor.
     */
    public function init()
    {
        $this->view = $this->container->get(ViewEngineInterface::class);
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
        return new \Zend\Diactoros\Response\HtmlResponse($this->view->render($templateName, $data), $status, $headers);
    }
}