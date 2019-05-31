<?php

use MorrisPhp\YouTubeApp\Controller\Controller;
use Slim\App;

return function (App $app) {
    $app->post('/youtube-search', Controller::class . ':create');
};
