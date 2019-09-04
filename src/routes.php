<?php

use app\controllers\HomeController;
use app\controllers\AdminController;
use app\controllers\Erro404;
use app\controllers\Erro500;

return function ($app) {
    $app->group("/admin", function ($app) {
        // Login
        $app->map(['GET', 'POST'], '', AdminController::class . ':login')->setName('login-barra-admin');
        $app->map(['GET', 'POST'], '/', AdminController::class . ':login')->setName('login-barra-admin');
        $app->map(['GET', 'POST'], '/login', AdminController::class . ':login')->setName('login-admin');
        // Dashboard
        $app->get('/dashboard', AdminController::class . ':dashboard')->setName('dashboard-admin');

        $app->get('/usuarios[/del/{id}]', AdminController::class . ':usuarios')->setName('usuarios-admin');
        $app->map(['GET', 'POST'], '/usuarios_modificacoes[/{id}]', AdminController::class . ':usuarios_modificacoes')->setName('usuarios-modificacoes-admin');
        
        $app->get('/areas[/del/{id}]', AdminController::class . ':areas')->setName('areas-admin');
        $app->map(['GET', 'POST'], '/areas_modificacoes[/{id}]', AdminController::class . ':areas_modificacoes')->setName('areas-modificacoes-admin');
        
        $app->get('/noticias[/del/{id}]', AdminController::class . ':noticias')->setName('noticias-admin');
        $app->map(['GET', 'POST'], '/noticias_modificacoes[/{id}]', AdminController::class . ':noticias_modificacoes')->setName('noticias-modificacoes-admin');
        
        $app->get('/editais[/del/{id}]', AdminController::class . ':editais')->setName('editais-admin');
        $app->map(['GET', 'POST'], '/editais_modificacoes[/{id}]', AdminController::class . ':editais_modificacoes')->setName('editais-modificacoes-admin');
        
        $app->get('/paginas[/del/{id}]', AdminController::class . ':paginas')->setName('paginas-admin');
        
        $app->get('/cronogramas[/del/{id}]', AdminController::class . ':cronogramas')->setName('cronogramas-admin');
        $app->map(['GET', 'POST'], '/cronogramas_modificacoes[/{id}]', AdminController::class . ':cronogramas_modificacoes')->setName('cronogramas-modificacoes-admin');
        
        $app->get('/apresentacoes[/del/{id}]', AdminController::class . ':apresentacoes')->setName('apresentacoes-admin');
        $app->map(['GET', 'POST'], '/apresentacoes_modificacoes[/{id}]', AdminController::class . ':apresentacoes_modificacoes')->setName('apresentacoes-modificacoes-admin');
        
        $app->get('/cursos_oficinas[/del/{id}]', AdminController::class . ':cursos_oficinas')->setName('cursos_oficinas-admin');
        $app->map(['GET', 'POST'], '/cursos_oficinas_modificacoes[/{id}]', AdminController::class . ':cursos_oficinas_modificacoes')->setName('cursos_oficinas-modificacoes-admin');
        
        $app->get('/palestras[/del/{id}]', AdminController::class . ':palestras')->setName('palestras-admin');
        $app->map(['GET', 'POST'], '/palestras_modificacoes[/{id}]', AdminController::class . ':palestras_modificacoes')->setName('palestras-modificacoes-admin');
        
        $app->get('/anos[/del/{id}]', AdminController::class . ':anos')->setName('anos-admin');
        $app->map(['GET', 'POST'], '/anos_modificacoes[/{id}]', AdminController::class . ':anos_modificacoes')->setName('anos-modificacoes-admin');
        
        // Conta
        $app->map(['GET', 'POST'], '/conta', AdminController::class . ':conta')->setName('conta-admin');
        // Sair
        $app->get('/sair', AdminController::class . ':sair')->setName('sair-admin');
        $app->get('/temp/{nome}', AdminController::class . ':template')->setName('template');
    });
    $app->get('/', HomeController::class . ':index')->setName('index');
    $app->get('/acomodacoes', HomeController::class . ':acomodacoes')->setName('index');
    $app->get('/noticias', HomeController::class . ':noticias')->setName('noticias');
    $app->get('/noticias/[{pagina}]', HomeController::class . ':noticias')->setName('noticias');
    $app->get('/noticia', HomeController::class . ':noticia')->setName('noticia');
    $app->get('/noticia/{id}', HomeController::class . ':noticia')->setName('index');
    $app->get('/editais', HomeController::class . ':editais')->setName('editais');
    $app->get('/editais/[{pagina}]', HomeController::class . ':editais')->setName('editais');
    $app->get('/edital', HomeController::class . ':edital')->setName('edital');
    $app->get('/edital/{id}', HomeController::class . ':edital')->setName('edital');
    $app->get('/palestras', HomeController::class . ':palestras')->setName('index');
    $app->get('/mini_cursos', HomeController::class . ':mini_cursos')->setName('mini_cursos');
    $app->get('/oficinas', HomeController::class . ':oficinas')->setName('oficinas');
    $app->get('/apresentacoes', HomeController::class . ':apresentacoes')->setName('apresentacoes');
    $app->get('/git', HomeController::class . ':git')->setName('git');
    // Paginas de Erro
    // $app->getContainer()['notFoundHandler'] = function($c){
    //     return new Erro404($c);
    // };
    // $app->getContainer()['errorHandler'] = function($c){
    //     return new Erro500($c);
    // };
};
