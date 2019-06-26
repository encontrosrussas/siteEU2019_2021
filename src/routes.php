<?php

use app\controllers\HomeController;
use app\controllers\AdminController;

return function ($app) {
    $app->group("/admin", function ($app) {
        // Login
        $app->get('/login', AdminController::class . ':login')->setName('login-admin');
        // Dashboard
        $app->get('/dashboard', AdminController::class . ':dashboard')->setName('dashboard-admin');
        $app->get('/usuarios', AdminController::class . ':usuarios')->setName('usuarios-admin');
        $app->get('/editais', AdminController::class . ':editais')->setName('editais-admin');
        $app->get('/paginas', AdminController::class . ':paginas')->setName('paginas-admin');
        $app->get('/cronogramas', AdminController::class . ':cronogramas')->setName('cronogramas-admin');
        $app->get('/apresentacoes', AdminController::class . ':apresentacoes')->setName('apresentacoes-admin');
        $app->get('/mini_cursos', AdminController::class . ':mini_cursos')->setName('mini_cursos-admin');
        $app->get('/palestras', AdminController::class . ':palestras')->setName('palestras-admin');
        // Conta
        $app->get('/conta', AdminController::class . ':conta')->setName('conta-admin');
        // Sair
        $app->get('/sair', AdminController::class . ':sair')->setName('sair-admin');
        $app->get('/temp/{nome}', AdminController::class . ':template')->setName('template');
    });
    $app->get('/{nome}', HomeController::class . ':home')->setName('index');
};
