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

    public function loadExtension($name)
    {
        try {
            $extension = $this->$name();
        } catch (\Exception $e) {
            $extension = null;
        }
        return $extension;
    }

    /**
     * Set the template's layout.
     * @param  string $name
     * @param  array $data
     * @return null
     */
    public function layout($name, array $data = array())
    {
        $this->layoutName = $name;
        $this->layoutData = array_merge($this->data(), $data);
    }
}