<?php

namespace MorrisPhp\YouTubeApi\Validation;

use MorrisPhp\YouTubeApi\MiddlewareInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class UriQueryValidationMiddleware implements MiddlewareInterface
{
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next): ResponseInterface
    {
        $q = $request->getQueryParams()['q'] ?? null;

        // Slim urldecodes the params before this
        // Therefore, don't need to allow %
        // Also + and %20 have are already whitespace by this point
        if (preg_match('/[^\w ]/', $q)) {
            $response->getBody()->write(json_encode(
                [
                    'error' => 'Invalid search characters - must be numeric, alpha, or single spaces.'
                ]
            ));
            return $response->withStatus(400);
        }

        return $next($request, $response);
    }
}
