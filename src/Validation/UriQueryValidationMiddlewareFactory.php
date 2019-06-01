<?php

namespace MorrisPhp\YouTubeApi\Validation;

use MorrisPhp\YouTubeApi\FactoryInterface;
use Psr\Container\ContainerInterface;

class UriQueryValidationMiddlewareFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container)
    {
        return new UriQueryValidationMiddleware();
    }
}
