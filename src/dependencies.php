<?php

use Monolog\Logger;
use MorrisPhp\YouTubeApi\Controller\Controller;
use MorrisPhp\YouTubeApi\Controller\ControllerFactory;
use MorrisPhp\YouTubeApi\YouTube\Service;
use MorrisPhp\YouTubeApi\YouTube\ServiceFactory;
use MorrisPhp\YouTubeApi\Repository\Repository;
use MorrisPhp\YouTubeApi\Repository\RepositoryFactory;
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

    $container[Google_Client::class] = function ($c) {
        $client = new Google_Client();
        $apiKey = $c->get('settings')['youtube']['api_key'];
        $client->setDeveloperKey($apiKey);
        return $client;
    };

    $container[Google_Service_YouTube::class] = function ($c) {
        $client = $c->get(Google_Client::class);
        return new Google_Service_YouTube($client);
    };

    $container[Service::class] = new ServiceFactory();
    $container[Controller::class] = new ControllerFactory();
    $container[Repository::class] = new RepositoryFactory();
};
