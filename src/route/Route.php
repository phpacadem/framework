<?php

namespace PhpAcadem\framework\route;


use Psr\Container\ContainerInterface;

class Route extends \League\Route\Route
{
    /**
     * Get the controller callable
     *
     * @param \Psr\Container\ContainerInterface|null $container
     *
     * @throws \InvalidArgumentException
     *
     * @return callable
     */
    public function getCallable(?ContainerInterface $container = null): callable
    {
        $callable = parent::getCallable($container);

        if (method_exists($callable[0], 'setContainer')) {
            $callable[0]->setContainer($container);
        }

        if (method_exists($callable[0], 'init')) {
            $callable[0]->init();
        }

        return $callable;
    }
}