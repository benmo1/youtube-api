<?php

namespace MorrisPhp\YouTubeApi\Middleware;

use MorrisPhp\YouTubeApi\FactoryInterface;
use Psr\Container\ContainerInterface;

class JsonContentTypeMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container): JsonContentTypeMiddleware
    {
        return new JsonContentTypeMiddleware();
    }
}
