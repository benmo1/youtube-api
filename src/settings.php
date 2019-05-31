<?php

return [
    'settings' => [
        'displayErrorDetails' => $_ENV['APPLICATION_ENV'] === 'development', // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        PDO::class => [
            'host' => $_ENV['MYSQL_HOST'],
            'database' => $_ENV['MYSQL_DATABASE'],
            'user' => $_ENV['MYSQL_USER'],
            'password' => $_ENV['MYSQL_PASSWORD'],
        ],

        'youtube_api_key' => $_ENV['YOUTUBE_API_KEY'],
    ],
];
