<?php

use Slim\App;
use MorrisPhp\YouTubeApp\Controller\Controller;

return function (App $app) {
    $container = $app->getContainer();

    // monolog
    $container['logger'] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    $container[Controller::class] = function ($c) {
        return new Controller();
    };
};
