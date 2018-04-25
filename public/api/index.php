<?php
if (PHP_SAPI == 'cli-server') {
    // To help the built-in PHP dev server, check if the request was actually for
    // something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

define('__ROOT__', __DIR__ . '/../../');


require __ROOT__ . 'vendor/autoload.php';

session_start();

// Instantiate the app
$settings = require __ROOT__ . 'src/settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
require __ROOT__ . 'src/dependencies.php';

// Register middleware
require __ROOT__ . 'src/middleware.php';

// Register routes
require __ROOT__ . 'src/routes.php';

// Run app
$app->run();
