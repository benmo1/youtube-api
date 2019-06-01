<?php

namespace MorrisPhp\YouTubeApi\Repository;

use MorrisPhp\YouTubeApi\FactoryInterface;
use PDO;
use Psr\Container\ContainerInterface;

class VideoRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container) : VideoRepository
    {
        return new VideoRepository($container->get(PDO::class));
    }
}
