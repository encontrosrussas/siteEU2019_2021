<?php

use \app\controllers\HomeController;

return function ($app) {
    $app->get('/{nome}', HomeController::class . ':home')->setName('index');
};
