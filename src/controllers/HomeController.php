<?php

namespace app\controllers;

class HomeController
{
    protected $container;
    protected $ano_atual;
    protected $anos;

    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
        $this->ano_atual = $container->db->select(
            "ano",
            [
                "id",
                "nome_ano",
            ],
            [
                "status" => 1
            ]
        )[0];
        $this->anos = $container->db->select(
            "ano",
            [
                "id",
                "nome_ano",
                "status"
            ], 
            [
                "ORDER" => ["nome_ano" => "DESC"],
            ]
        );
        if (isset($_SESSION['ano'])){
            foreach($this->anos as $ano){
                if($ano['id'] == $_SESSION['ano']){
                    $this->ano_atual = $ano;
                }
            }
        }
    }

    public function index($request, $response, $args){
        if($args['ano']) {
            if ($args['ano'] != $this->ano_atual['id']){
                $_SESSION['ano'] = $args['ano'];
                foreach ($this->anos as $ano) {
                    if ($ano['id'] == $_SESSION['ano']) {
                        $this->ano_atual = $ano;
                    }
                }
            } else {
                unset($_SESSION['ano']);
            }
        }
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
            [
                "ano_id" => $this->ano_atual['id'],
                'LIMIT' => 8,
                "ORDER" => [
                    'id' => "DESC"
                ]
            ]
        );
        $calendario = $this->container->db->select(
            "calendario",
            [
                'data',
                'descricao'
            ],
            [
                "ano_id" => $this->ano_atual['id'],
                "ORDER" => [
                    'id' => "ASC"
                ]
            ]
        );
        return $this->container->view->render($response, 'front/index.html',[
            'noticias' => $noticias,
            'calendario' => $calendario,
            'anos' => $this->anos
        ]);
    }

    public function certificados($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'front/certificados.html',[
                'anos' => $this->anos
            ]
        );
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
                'cursos_oficinas.imagem_descricao',
                'area.nome(area)',
            ],
            [
                'AND'=>[
                    "ano_id" => $this->ano_atual['id'],
                    'cursos_oficinas.tipo' => 1
                ]
            ]
        );
        return $this->container->view->render(
            $response,
            'front/mini_cursos.html',
            [
                'mini_cursos'=>$mini_cursos,
                'anos' => $this->anos
            ]
        );
    }

    public function apresentacoes($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $apresentacoes = [];
        $apresentacoes = $db->select(
            "apresentacoes",
            [
                "[><]ano" => [
                    "apresentacoes.ano_id" => "id"
                ],
            ],
            [
                'apresentacoes.id',
                'apresentacoes.nome',
                'apresentacoes.autor',
                'apresentacoes.resumo',
                'apresentacoes.trilha',
            ],
            [
                'AND' => [
                    "ano_id" => $this->ano_atual['id'],
                ]
            ]
        );
        return $this->container->view->render(
            $response,
            'front/apresentacoes.html',
            [
                'apresentacoes' => $apresentacoes,
                'anos' => $this->anos
            ]
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
                'cursos_oficinas.imagem_descricao',
                'area.nome(area)',
            ],
            [
                'AND' => [
                    "ano_id" => $this->ano_atual['id'],
                    'cursos_oficinas.tipo' => 2
                ]
            ]
        );
        return $this->container->view->render(
            $response,
            'front/oficinas.html',
            [
                'oficinas' => $oficinas,
                'anos' => $this->anos
            ]
        );
    }

    public function noticias($request, $response, $args){
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [
            'anos' => $this->anos
        ];
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
                "ano_id" => $this->ano_atual['id'],
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
                "ano_id" => $this->ano_atual['id'],
                'LIMIT' => [$pag, $itemsPorPagina],
                "ORDER" => [
                    'id' => "DESC"
                ]
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
        $argumentos = ['anos' => $this->anos];
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
                    'noticias.imagem_descricao',
                    'noticias.conteudo'
                ],
                [
                    "ano_id" => $this->ano_atual['id'],
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
                    'noticias.imagem_descricao',
                ],
                [
                    "ano_id" => $this->ano_atual['id'],
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
        $argumentos = ['anos' => $this->anos];
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
                "ano_id" => $this->ano_atual['id'],
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
                "ano_id" => $this->ano_atual['id'],
                'LIMIT' => [$pag, $itemsPorPagina],
                "ORDER" => [
                    'id' => "DESC"
                ]
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
        $argumentos = ['anos' => $this->anos];
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
                    "ano_id" => $this->ano_atual['id'],
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
        $argumentos = ['anos' => $this->anos];
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
                'palestras.imagem_descricao',
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
        $argumentos = ['anos' => $this->anos];
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
                'artistico.imagem_descricao',
                'area.nome(area)',
            ],
            [
                "ano_id" => $this->ano_atual['id'],
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
        $argumentos = ['anos' => $this->anos];
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
                'artistico.imagem_descricao',
                'area.nome(area)',
            ],
            [
                "ano_id" => $this->ano_atual['id'],
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
        $argumentos = ['anos' => $this->anos];
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
                'artistico.imagem_descricao',
                'area.nome(area)',
            ],
            [
                "ano_id" => $this->ano_atual['id'],
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
        $argumentos = ['anos' => $this->anos];
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
                'artistico.imagem_descricao',
                'area.nome(area)',
            ],
            [
                "ano_id" => $this->ano_atual['id'],
                'artistico.tipo' => 4
            ]
        );
        return $this->container->view->render(
            $response,
            'front/espaco_gastronomico.html',
            $argumentos
        );
    }

    public function manual($request, $response, $args){
        return $this->container->view->render(
            $response,
            'front/manual.html',[
                'anos' => $this->anos
            ]
        );
    }

    public function emBreve($request, $response, $args){
        return $this->container->view->render(
            $response,
            'front/emBreve.html',[
                'anos' => $this->anos
            ]
        );
    }
}