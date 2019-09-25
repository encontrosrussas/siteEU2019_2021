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
        foreach(scandir("src/views-cache") as $ind){
            if($ind!='.' && $ind!='..' && $ind!='read.txt'){
                $dir = "src/views-cache/" . $ind;
                foreach(scandir($dir) as $arq){
                    if ($arq != '.' && $arq != '..') {
                        unlink($dir.'/'.$arq);
                    }
                }
                rmdir("src/views-cache/".$ind);
            }
        }
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
        $db = $this->container->db;
        $argumentos = [];
        $itemsPorPagina = 10;
        $qtdItems = $db->count(
            "noticias",
            [
                "[><]ano" => [
                    "noticias.ano_id" => "id"
                ],
            ],
            [
                'noticias.id',
            ],
            [
                'ano.status' => 1,
            ]
        );
        #quantidade de paginas
        $num_pag = ceil($qtdItems / $itemsPorPagina);
        $argumentos['paginas'] = $num_pag;
        $argumentos['pagina_atual'] = isset($args['pagina']) && $args['pagina'] <= $num_pag && $args['pagina'] > 0 ? $args['pagina'] : 1;
        $pag = isset($args['pagina']) && $args['pagina'] <= $num_pag && $args['pagina'] > 0 ? ($args['pagina'] - 1) * $itemsPorPagina : 0;
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
                'LIMIT' => [$pag, $itemsPorPagina]
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
                    'ano.status' => 1,
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

    public function editais($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        $itemsPorPagina = 10;
        $qtdItems = $db->count(
            "editais",
            [
                "[><]ano" => [
                    "editais.ano_id" => "id"
                ],
            ],
            [
                'editais.id',
            ],
            [
                'ano.status' => 1,
            ]
        );
        #quantidade de paginas
        $num_pag = ceil($qtdItems / $itemsPorPagina);
        $argumentos['paginas'] = $num_pag;
        $argumentos['pagina_atual'] = isset($args['pagina']) && $args['pagina'] <= $num_pag && $args['pagina'] > 0 ? $args['pagina'] : 1;
        $pag = isset($args['pagina']) && $args['pagina'] <= $num_pag && $args['pagina'] > 0 ? ($args['pagina'] - 1) * $itemsPorPagina : 0;
        $argumentos['editais'] = $db->select(
            "editais",
            [
                "[><]ano" => [
                    "editais.ano_id" => "id"
                ],
            ],
            [
                'editais.id',
                'editais.nome',
                'editais.tipo'
            ],
            [
                'ano.status' => 1,
                'LIMIT' => [$pag, $itemsPorPagina]
            ]
        );
        return $this->container->view->render(
            $response,
            'front/editais.html',
            $argumentos
        );
    }

    public function edital($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $argumentos = [];
        $db = $this->container->db;
        if (isset($args['id'])) {
            $edital = $db->select(
                "editais",
                [
                    "[><]ano" => [
                        "editais.ano_id" => "id"
                    ],
                ],
                [
                    'editais.id',
                    'editais.nome',
                    'editais.tipo',
                    'editais.descricao',
                    'editais.arquivo'
                ],
                [
                    'editais.id' => $args['id']
                ]
            );
            if (count($edital) == 1) {
                $argumentos['edital'] = $edital[0];
                return $this->container->view->render(
                    $response,
                    'front/edital.html',
                    $argumentos
                );
            }
        }
        return $response->withRedirect('/editais');
    }

    public function palestras($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        $argumentos['palestras'] = $db->select(
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
            $argumentos
        );
    }

    public function palco_mix($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        $argumentos['palco_mix'] = $db->select(
            "artistico",
            [
                "[><]ano" => [
                    "artistico.ano_id" => "id"
                ],
                "[><]area" => [
                    "artistico.area_id" => "id"
                ],
            ],
            [
                'artistico.id',
                'artistico.titulo',
                'artistico.facilitador',
                'artistico.data',
                'artistico.resumo',
                'artistico.local',
                'artistico.imagem',
                'area.nome(area)',
            ],
            [
                'ano.status' => 1,
                'artistico.tipo' => 1
            ]
        );
        return $this->container->view->render(
            $response,
            'front/palco_mix.html',
            $argumentos
        );
    }

    public function mostra_audiovisual($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        $argumentos['mostras_audiovisual'] = $db->select(
            "artistico",
            [
                "[><]ano" => [
                    "artistico.ano_id" => "id"
                ],
                "[><]area" => [
                    "artistico.area_id" => "id"
                ],
            ],
            [
                'artistico.id',
                'artistico.titulo',
                'artistico.facilitador',
                'artistico.data',
                'artistico.resumo',
                'artistico.local',
                'artistico.imagem',
                'area.nome(area)',
            ],
            [
                'ano.status' => 1,
                'artistico.tipo' => 2
            ]
        );
        return $this->container->view->render(
            $response,
            'front/mostra_audiovisual.html',
            $argumentos
        );
    }

    public function feira_de_artesanato($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        $argumentos['feira_de_artesanatos'] = $db->select(
            "artistico",
            [
                "[><]ano" => [
                    "artistico.ano_id" => "id"
                ],
                "[><]area" => [
                    "artistico.area_id" => "id"
                ],
            ],
            [
                'artistico.id',
                'artistico.titulo',
                'artistico.facilitador',
                'artistico.data',
                'artistico.resumo',
                'artistico.local',
                'artistico.imagem',
                'area.nome(area)',
            ],
            [
                'ano.status' => 1,
                'artistico.tipo' => 3
            ]
        );
        return $this->container->view->render(
            $response,
            'front/feira_de_artesanato.html',
            $argumentos
        );
    }

    public function espaco_gastronomico($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        $argumentos['espacos_gastronomicos'] = $db->select(
            "artistico",
            [
                "[><]ano" => [
                    "artistico.ano_id" => "id"
                ],
                "[><]area" => [
                    "artistico.area_id" => "id"
                ],
            ],
            [
                'artistico.id',
                'artistico.titulo',
                'artistico.facilitador',
                'artistico.data',
                'artistico.resumo',
                'artistico.local',
                'artistico.imagem',
                'area.nome(area)',
            ],
            [
                'ano.status' => 1,
                'artistico.tipo' => 4
            ]
        );
        return $this->container->view->render(
            $response,
            'front/espaco_gastronomico.html',
            $argumentos
        );
    }

    public function emBreve($request, $response, $args){
        return $this->container->view->render(
            $response,
            'front/emBreve.html'
        );
    }

    public function removeViews($request, $response, $args){
        foreach (scandir("src/views-cache") as $ind) {
            if ($ind != '.' && $ind != '..' && $ind != 'read.txt') {
                $dir = "src/views-cache/" . $ind;
                foreach (scandir($dir) as $arq) {
                    if ($arq != '.' && $arq != '..') {
                        unlink($dir . '/' . $arq);
                        dump($dir . '/' . $arq);
                    }
                }
                rmdir("src/views-cache/" . $ind);
                dump($dir);
            }
        }
    }
}