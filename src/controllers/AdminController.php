<?php

namespace app\controllers;

class AdminController
{
    protected $container;

    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function login($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '/' route");
        return $this->container->view->render($response, 'admin/login.html');
    }

    public function template($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '/' route");
        return $this->container->view->render($response, 'admin/template/'.$args['nome']);
    }
}
