<?php

namespace MorrisPhp\YouTubeApi\Controller;

use MorrisPhp\YouTubeApi\Repository\ChannelRepository;
use MorrisPhp\YouTubeApi\Repository\VideoRepository;
use MorrisPhp\YouTubeApi\YouTube\Service;
use MorrisPhp\YouTubeApi\FactoryInterface;
use Psr\Container\ContainerInterface;

class ControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): Controller
    {
        return new Controller(
            $container->get(Service::class),
            $container->get(ChannelRepository::class),
            $container->get(VideoRepository::class)
        );
    }
}
