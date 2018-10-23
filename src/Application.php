<?php

namespace PhpAcadem\framework;


use PhpAcadem\framework\route\Router;
use League\Plates\Engine;

class Application extends Router
{
    /** @var Engine */
    protected $view;

    /**
     * @return Engine
     */
    public function getView(): Engine
    {
        return $this->view;
    }

    /**
     * @param Engine $view
     */
    public function setView(Engine $view): void
    {
        $this->view = $view;
    }

}