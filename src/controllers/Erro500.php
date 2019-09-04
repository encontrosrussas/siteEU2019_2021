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
            'front/error500.html'
        );
    }
}