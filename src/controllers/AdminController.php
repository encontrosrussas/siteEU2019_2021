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
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/login.html');
    }

    public function dashboard($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/index.html');
    }

    public function usuarios($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/usuarios.html');
    }

    public function editais($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/editais.html');
    }

    public function paginas($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/paginas.html');
    }

    public function cronogramas($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/cronogramas.html');
    }

    public function apresentacoes($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/apresentacoes.html');
    }

    public function mini_cursos($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/mini_cursos.html');
    }

    public function palestras($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/palestras.html');
    }

    public function template($request, $response, $args)
    {
        $this->container->get('logger')->info("slim-app '{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/template/'.$args['nome']);
    }
}
