<?php

namespace MorrisPhp\YouTubeApi\Repository;

use MorrisPhp\YouTubeApi\FactoryInterface;
use PDO;
use Psr\Container\ContainerInterface;

class ChannelRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): ChannelRepository
    {
        return new ChannelRepository($container->get(PDO::class));
    }
}
