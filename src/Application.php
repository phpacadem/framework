<?php

namespace PhpAcadem\framework;


use PhpAcadem\framework\route\Router;
use PhpAcadem\framework\view\ViewEngineInterface;

class Application extends Router
{
    /** @var ViewEngineInterface */
    protected $view;

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

}