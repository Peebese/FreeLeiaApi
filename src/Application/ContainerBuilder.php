<?php

namespace PhilipBrown\ThisIsBud\Application;

use DI\Container;

class ContainerBuilder
{
    public function buildContainer(): Container
    {
        $containerArray =  include __DIR__ . '/../../config/di.php';
        $container = new Container();

        foreach ($containerArray as $containerKey => $conVal) {
            $container->set($containerKey,$conVal);
        }

        return $container;
    }
}