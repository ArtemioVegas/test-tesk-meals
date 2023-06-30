<?php

namespace tests\Meals\Functional;

use Symfony\Component\DependencyInjection\ContainerBuilder;

class StaticContainer
{
    /** @var ContainerBuilder */
    static $container;

    public static function setContainer(ContainerBuilder $container)
    {
        self::$container = $container;
    }

    public function getContainer(): ContainerBuilder
    {
        return self::$container;
    }
}
