<?php

use MorrisPhp\YouTubeApi\Controller\Controller;
use MorrisPhp\YouTubeApi\Middleware\UriQueryValidationMiddleware;
use Slim\App;

return function (App $app) {
    $app->post('/youtube-search', Controller::class . ':create');
    $app->get('/youtube-search', Controller::class . ':getAll')
        ->add(UriQueryValidationMiddleware::class);
    $app->get('/youtube-search/{id:[1-9][0-9]*}', Controller::class . ':get');
    $app->delete('/youtube-search/{id:[1-9][0-9]*}', Controller::class . ':destroy');
};
