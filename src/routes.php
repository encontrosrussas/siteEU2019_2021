<?php

use \app\controllers\HomeController;
use app\controllers\AdminController;

return function ($app) {
    $app->group("/admin", function ($app) {
        $app->get('/login', AdminController::class . ':login')->setName('login-admin');
        $app->get('/temp/{nome}', AdminController::class . ':template')->setName('template');
    });
    $app->get('/{nome}', HomeController::class . ':home')->setName('index');
};
