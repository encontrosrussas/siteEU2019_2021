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
                'subtitulo',
                'imagem',
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
        $argumentos = [];
        $db = $this->container->db;
        $argumentos['noticias'] = $db->select(
            "noticias",
            [
                "[><]ano" => [
                    "noticias.ano_id" => "id"
                ],
            ],
            [
                'noticias.id',
                'noticias.titulo',
                'noticias.subtitulo',
                'noticias.data',
                'noticias.hora'
            ],
            [
                'LIMIT' => 6
            ]
        );
        return $this->container->view->render(
            $response,
            'front/noticias.html',
            $argumentos
        );
    }

    public function noticia($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $argumentos = [];
        $db = $this->container->db;
        if (isset($args['id'])) {
            $noticia = $db->select(
                "noticias",
                [
                    "[><]ano" => [
                        "noticias.ano_id" => "id"
                    ],
                ],
                [
                    'noticias.id',
                    'noticias.titulo',
                    'noticias.subtitulo',
                    'noticias.data',
                    'noticias.hora',
                    'noticias.imagem',
                    'noticias.conteudo'
                ],
                [
                    'noticias.id' => $args['id']
                ]
            );
            $argumentos['noticias'] = $db->select(
                "noticias",
                [
                    "[><]ano" => [
                        "noticias.ano_id" => "id"
                    ],
                ],
                [
                    'noticias.id',
                    'noticias.titulo',
                    'noticias.imagem',
                ],
                [
                    'noticias.id[!]' => $args['id'],
                    'LIMIT' => 4
                ]
            );
            if(count($noticia)==1){
                $argumentos['noticia'] = $noticia[0];
                return $this->container->view->render(
                    $response,
                    'front/noticia.html',
                    $argumentos
                );
            }
        }
        return $response->withRedirect('/noticias');
    }

    public function palestras($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'front/palestras.html');
    }

}