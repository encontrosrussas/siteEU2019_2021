<?php

namespace app\controllers;

class Erro500
{
    protected $container;

    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function __invoke($request, $response)
    {
        return $this->container->view->render(
            $response->withStatus(500)
                     ->withHeader('Content-Type', 'text/html'),
            'front/2018/error500.html',
            [
                'ano_atual' => [
                    'nome_ano' => 2018
                ]
            ]
        );
    }
}