<?php

namespace MorrisPhp\YouTubeApi\Controller;

use MorrisPhp\YouTubeApi\Repository\Repository;
use MorrisPhp\YouTubeApi\YouTube\Service;
use MorrisPhp\YouTubeApi\FactoryInterface;
use Psr\Container\ContainerInterface;

class ControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container) : Controller
    {
        return new Controller(
            $container->get(Service::class),
            $container->get(Repository::class)
        );
    }
}
