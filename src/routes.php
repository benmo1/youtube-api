<?php

use MorrisPhp\YouTubeApi\Controller\Controller;
use Slim\App;

return function (App $app) {
    $app->post('/youtube-search', Controller::class . ':create');
    $app->get('/youtube-search', Controller::class . ':getAll');
    $app->get('/youtube-search/{id:[1-9][0-9]*}', Controller::class . ':get');
};
