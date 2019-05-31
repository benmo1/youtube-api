<?php

use Monolog\Logger;
use MorrisPhp\YouTubeApp\Controller\Controller;
use Slim\App;

return function (App $app) {
    $container = $app->getContainer();

    $container[Logger::class] = function ($c) {
        $settings = $c->get('settings')['logger'];
        $logger = new \Monolog\Logger($settings['name']);
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
        return $logger;
    };

    $container[PDO::class] = function ($c) {
        $settings = $c->get('settings')['database'];
        $dsn = sprintf('mysql:host=%s;dbname=%s',
            $settings['host'],
            $settings['database'],
        );

        return new PDO(
            $dsn,
            $settings['user'],
            $settings['password'],
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    };

    $container[Controller::class] = function ($c) {
        return new Controller();
    };
};
