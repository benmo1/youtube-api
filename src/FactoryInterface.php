<?php

namespace MorrisPhp\YouTubeApi;

use Psr\Container\ContainerInterface;

interface FactoryInterface
{
    public function __invoke(ContainerInterface $container);
}
