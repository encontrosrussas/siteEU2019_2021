<?php

namespace app\controllers;

class HomeController
{
    protected $container;

    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function index($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $noticias = $this->container->db->select(
            "noticias",
            [
                'id',
                'titulo',
                'conteudo'
            ],
            ['ano_id' => 1, 'LIMIT' => 8]
        );
        return $this->container->view->render($response, 'front/index.html',[
            'noticias' => $noticias
        ]);
    }

    public function acomodacoes($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'front/acomodacoes.html');
    }

    public function mini_cursos($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'front/mini_cursos.html');
    }

    public function noticias($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'front/noticias.html');
    }

    public function noticia($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'front/noticia.html');
    }

    public function palestras($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'front/palestras.html');
    }

}