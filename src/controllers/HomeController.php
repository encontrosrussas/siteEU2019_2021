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
        $db = $this->container->db;
        $mini_cursos = $db->select(
            "cursos_oficinas",
            [
                "[><]ano" => [
                    "cursos_oficinas.ano_id" => "id"
                ],
                "[><]area" => [
                    "cursos_oficinas.area_id" => "id"
                ],
            ],
            [
                'cursos_oficinas.id',
                'cursos_oficinas.titulo',
                'cursos_oficinas.nome',
                'cursos_oficinas.data',
                'cursos_oficinas.hora',
                'cursos_oficinas.resumo',
                'cursos_oficinas.sala',
                'cursos_oficinas.imagem',
                'area.nome(area)',
            ],
            [
                'AND'=>[
                    'ano.status' => 1,
                    'cursos_oficinas.tipo' => 1
                ]
            ]
        );
        return $this->container->view->render(
            $response,
            'front/mini_cursos.html',
            ['mini_cursos'=>$mini_cursos]
        );
    }

    public function apresentacoes($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        // $db = $this->container->db;
        $apresentacoes = [];
        // $apresentacoes = $db->select(
        //     "apresentacoes",
        //     [
        //         "[><]ano" => [
        //             "apresentacoes.ano_id" => "id"
        //         ],
        //         "[><]area" => [
        //             "apresentacoes.area_id" => "id"
        //         ],
        //     ],
        //     [
        //         'apresentacoes.id',
        //         'apresentacoes.titulo',
        //         'apresentacoes.nome',
        //         'apresentacoes.data',
        //         'apresentacoes.hora',
        //         'apresentacoes.resumo',
        //         'apresentacoes.sala',
        //         'apresentacoes.imagem',
        //         'area.nome(area)',
        //     ],
        //     [
        //         'AND' => [
        //             'ano.status' => 1,
        //             'apresentacoes.tipo' => 1
        //         ]
        //     ]
        // );
        return $this->container->view->render(
            $response,
            'front/apresentacoes.html',
            ['apresentacoes' => $apresentacoes]
        );
    }

    public function oficinas($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $oficinas = $db->select(
            "cursos_oficinas",
            [
                "[><]ano" => [
                    "cursos_oficinas.ano_id" => "id"
                ],
                "[><]area" => [
                    "cursos_oficinas.area_id" => "id"
                ],
            ],
            [
                'cursos_oficinas.id',
                'cursos_oficinas.titulo',
                'cursos_oficinas.nome',
                'cursos_oficinas.data',
                'cursos_oficinas.hora',
                'cursos_oficinas.resumo',
                'cursos_oficinas.sala',
                'cursos_oficinas.imagem',
                'area.nome(area)',
            ],
            [
                'AND' => [
                    'ano.status' => 1,
                    'cursos_oficinas.tipo' => 2
                ]
            ]
        );
        return $this->container->view->render(
            $response,
            'front/oficinas.html',
            ['oficinas' => $oficinas]
        );
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
                'ano.status' => 1,
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
        $db = $this->container->db;
        $palestras = $db->select(
            "palestras",
            [
                "[><]ano" => [
                    "palestras.ano_id" => "id"
                ],
                "[><]area" => [
                    "palestras.area_id" => "id"
                ],
            ],
            [
                'palestras.id',
                'palestras.titulo',
                'palestras.nome',
                'palestras.data',
                'palestras.hora',
                'palestras.resumo',
                'palestras.sala',
                'palestras.imagem',
                'area.nome(area)',
            ],
            [
                'ano.status' => 1
            ]
        );
        return $this->container->view->render(
            $response,
            'front/palestras.html',
            ['palestras'=>$palestras]
        );
    }

}