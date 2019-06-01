<?php

use MorrisPhp\YouTubeApi\Controller\Controller;
use MorrisPhp\YouTubeApi\Middleware\JsonContentTypeMiddleware;
use MorrisPhp\YouTubeApi\Middleware\UriQueryValidationMiddleware;
use Slim\App;

return function (App $app) {
    $app->group('/youtube-search', function (App $app) {
        $app->post('', Controller::class . ':create');
        $app->get('', Controller::class . ':getAll')
            ->add(UriQueryValidationMiddleware::class);
        $app->get('/{id:[1-9][0-9]*}', Controller::class . ':get');
        $app->delete('/{id:[1-9][0-9]*}', Controller::class . ':destroy');
    })->add(JsonContentTypeMiddleware::class);
};
