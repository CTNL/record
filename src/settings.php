<?php
return [
    'settings' => [
        'displayErrorDetails' => true, // set to false in production
        'addContentLengthHeader' => false, // Allow the web server to send the content-length header

        // Renderer settings
        'renderer' => [
            'template_path' => __ROOT__ . 'templates/',
        ],

        // Monolog settings
        'logger' => [
            'name' => 'slim-app',
            'path' => isset($_ENV['docker']) ? 'php://stdout' : __ROOT__ . 'logs/app.log',
            'level' => \Monolog\Logger::DEBUG,
        ],

        'db' => [
            'driver' => 'mysql',
            'host' => 'mysql',
            'username' => 'root',
            'password' => 'root',
            'database' => 'record18',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
    ],
];
