<?php

namespace PhpAcadem\framework\route;

interface UrlInterface
{
    public function get($routeName, $params = []);
}