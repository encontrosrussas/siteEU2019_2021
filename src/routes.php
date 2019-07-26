<?php

use app\controllers\HomeController;
use app\controllers\AdminController;

return function ($app) {
    $app->group("/admin", function ($app) {
        // Login
        $app->get('/login', AdminController::class . ':login')->setName('login-admin');
        // Dashboard
        $app->get('/', AdminController::class . ':dashboard')->setName('dashboard-admin');
        $app->get('/dashboard', AdminController::class . ':dashboard')->setName('dashboard-admin');
        $app->get('/usuarios[/del/{id}]', AdminController::class . ':usuarios')->setName('usuarios-admin');
        $app->map(['GET', 'POST'], '/usuarios_modificacoes[/{id}]', AdminController::class . ':usuarios_modificacoes')->setName('usuarios-modificacoes-admin');
        $app->get('/areas[/del/{id}]', AdminController::class . ':areas')->setName('areas-admin');
        $app->map(['GET', 'POST'], '/areas_modificacoes[/{id}]', AdminController::class . ':areas_modificacoes')->setName('areas-modificacoes-admin');
        $app->get('/noticias[/del/{id}]', AdminController::class . ':noticias')->setName('noticias-admin');
        $app->get('/editais[/del/{id}]', AdminController::class . ':editais')->setName('editais-admin');
        $app->get('/paginas[/del/{id}]', AdminController::class . ':paginas')->setName('paginas-admin');
        $app->get('/cronogramas[/del/{id}]', AdminController::class . ':cronogramas')->setName('cronogramas-admin');
        $app->get('/apresentacoes[/del/{id}]', AdminController::class . ':apresentacoes')->setName('apresentacoes-admin');
        $app->get('/mini_cursos[/del/{id}]', AdminController::class . ':mini_cursos')->setName('mini_cursos-admin');
        $app->get('/palestras[/del/{id}]', AdminController::class . ':palestras')->setName('palestras-admin');
        $app->get('/anos[/del/{id}]', AdminController::class . ':anos')->setName('anos-admin');
        $app->map(['GET', 'POST'], '/anos_modificacoes[/{id}]', AdminController::class . ':anos_modificacoes')->setName('anos-modificacoes-admin');
        // Conta
        $app->get('/conta', AdminController::class . ':conta')->setName('conta-admin');
        // Sair
        $app->get('/sair', AdminController::class . ':sair')->setName('sair-admin');
        $app->get('/temp/{nome}', AdminController::class . ':template')->setName('template');
    });
    $app->get('/{nome}', HomeController::class . ':home')->setName('index');
};
