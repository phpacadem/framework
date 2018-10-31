<?php

namespace PhpAcadem\framework\view;


use League\Plates\Extension\ExtensionInterface;

interface ViewEngineInterface
{
    public function addData(array $data, $templates = null);

    public function getData($template = null);

    /**
     * Load an extension.
     * @param  ExtensionInterface $extension
     * @return ViewEngineInterface
     */
    public function loadExtension(ExtensionInterface $extension);

    public function render($name, array $data = array());
}