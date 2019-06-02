<?php

namespace MorrisPhp\YouTubeApi\Middleware;

use MorrisPhp\YouTubeApi\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class JsonContentTypeMiddleware implements MiddlewareInterface
{
    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next
    ): ResponseInterface {
        /** @var ResponseInterface $response */
        $response = $next($request, $response);
        return $response->withHeader('Content-Type', 'application/json');
    }
}
