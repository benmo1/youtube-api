<?php

namespace MorrisPhp\YouTubeApi\Repository;

use MorrisPhp\YouTubeApi\FactoryInterface;
use PDO;
use Psr\Container\ContainerInterface;

class RepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container) : Repository
    {
        return new Repository($container->get(PDO::class));
    }
}
