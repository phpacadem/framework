<?php

namespace PhpAcadem\framework\view;


use League\Plates\Engine;
use PhpAcadem\framework\route\UrlInterface;

class ViewEngine extends Engine implements ViewEngineInterface
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

    /**
     * Create a new template.
     * @param  string $name
     * @return Template
     */
    public function make($name)
    {
        $template = new Template($this, $name);
        $template->setUrl($this->url);
        return $template;
    }
}