<?php

namespace MorrisPhp\YouTubeApi\YouTube;

use MorrisPhp\YouTubeApi\FactoryInterface;
use Psr\Container\ContainerInterface;

class ServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container) : Service
    {
        $vendorService = $container->get(\Google_Service_YouTube::class);
        $filterPath = $container->get('settings')['youtube']['filter_path'];

        return new Service($vendorService, $filterPath);
    }
}