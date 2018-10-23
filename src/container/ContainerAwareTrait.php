<?php


namespace PhpAcadem\framework\container;


use Psr\Container\ContainerInterface;

trait ContainerAwareTrait
{
    /**
     * @var \Psr\Container\ContainerInterface|null
     */
    protected $container;

    /**
     * {@inheritdoc}
     */
    public function getContainer(): ?ContainerInterface
    {
        return $this->container;
    }

    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container): self
    {
        $this->container = $container;

        return $this;
    }
}
