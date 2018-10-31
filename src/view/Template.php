<?php

namespace PhpAcadem\framework\view;


use PhpAcadem\framework\route\UrlInterface;

class Template extends \League\Plates\Template\Template
{
    /** @var UrlInterface */
    protected $url;

    /**
     * @param UrlInterface $url
     */
    public function setUrl(UrlInterface $url): void
    {
        $this->url = $url;
    }

    public function url($routeName, $params = [])
    {
        return $this->url->get($routeName, $params);
    }
}