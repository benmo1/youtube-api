<?php

namespace MorrisPhp\YouTubeApi\Middleware;

use MorrisPhp\YouTubeApi\FactoryInterface;
use Psr\Container\ContainerInterface;

class UriQueryValidationMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): UriQueryValidationMiddleware
    {
        return new UriQueryValidationMiddleware();
    }
}
