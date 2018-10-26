<?php

namespace PhpAcadem\framework\container;


class ContainerBuilder extends \DI\ContainerBuilder
{
    public function __construct(string $containerClass = 'DI\Container')
    {
        parent::__construct($containerClass);
        $this->addDefinitions(__DIR__ . '/../services.php');
    }

}