<?php

namespace PhpAcadem\framework\view;


interface ViewEngineInterface
{
    public function addData(array $data, $templates = null);

    public function getData($template = null);

    public function render($name, array $data = array());
}