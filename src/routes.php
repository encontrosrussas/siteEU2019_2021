<?php

use \app\controllers\HomeController;
use app\controllers\LoginControllerAdmin;

return function ($app) {
    $app->group("/admin", function ($app) {
        $app->get('/{nome}', LoginControllerAdmin::class . ':home')->setName('index');
    });
    $app->get('/{nome}', HomeController::class . ':home')->setName('index');
};
