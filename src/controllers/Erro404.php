<?php

namespace app\controllers;

class Erro404
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
            $response->withStatus(404)
                     ->withHeader('Content-Type', 'text/html'),
            'front/error404.html'
        );
    }
}