<?php

require __DIR__ . DIRECTORY_SEPARATOR ."vendor" . DIRECTORY_SEPARATOR. "autoload.php";
date_default_timezone_set("America/Fortaleza");
// Instantiate the app
$settings = require __DIR__ . DIRECTORY_SEPARATOR .'src'. DIRECTORY_SEPARATOR .'settings.php';
$app = new \Slim\App($settings);

// Set up dependencies
$dependencies = require __DIR__ . DIRECTORY_SEPARATOR .'src' . DIRECTORY_SEPARATOR . 'dependencies.php';
$dependencies($app);

// Register middleware
$middleware = require __DIR__ . DIRECTORY_SEPARATOR .'src' . DIRECTORY_SEPARATOR . 'middleware.php';
$middleware($app);

// Register routes
$routes = require __DIR__ . DIRECTORY_SEPARATOR .'src'. DIRECTORY_SEPARATOR .'routes.php';
$routes($app);

$app->run();