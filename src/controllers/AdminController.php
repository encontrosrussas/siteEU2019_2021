<?php

namespace app\controllers;

use app\models\Ano;
use app\models\Apresentacao;
use app\models\Area;
use app\models\Cronograma;
use app\models\Edital;
use app\models\MiniCurso;
use app\models\Noticia;
use app\models\Palestra;
use app\models\Usuario;
use app\helpers\Upload;
use app\helpers\Login;

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
        Login::redirectLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody()) && $_POST['email'] != '' && $_POST['password'] != '') {
            $argumentos['mensagens'] = [];
            $email = trim(strip_tags(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING)));
            $senha = trim(strip_tags(filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING)));
            $user = new Usuario();
            $user->setEmail($email);
            $user->setSenha($senha);
            $login = new Login($user, $db);
            $login->setEmail($email);
            $login->setPassword($senha);
            $login->logar();
            return $response->withRedirect('/admin');
        }
        return $this->container->view->render($response, 'admin/login.html');
    }

    public function dashboard($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        $argumentos = [];
        $argumentos['usuarios']=$db->count(
            "usuarios"
        );
        $argumentos['apresentacoes']=$db->count(
            "apresentacoes"
        );
        $argumentos['mini_cursos']=$db->count(
            "mini_cursos"
        );
        $argumentos['palestras']=$db->count(
            "palestras"
        );
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/index.html',
            $argumentos
        );
    }

    public function usuarios($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if(isset($args['id'])){
            $db->delete(
                "usuarios",
                ["id"=>$args['id']]
            );
        }
        $usuarios = $db->select("usuarios", [
            'id', 'nome', 'email', 'tipo'
        ]);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/usuarios.html',[
            'usuarios'=>$usuarios
        ]);
    }
    
    public function usuarios_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if(!filter_var($dados['email'], FILTER_VALIDATE_EMAIL))
                array_push($argumentos['mensagens'], 'Email Invalido!');
            if(empty($dados['enviar']) && ($dados['pass'] != $dados['confirm-pass'] || empty($dados['pass']) || is_null($dados['pass'])))
                array_push($argumentos['mensagens'], 'Senha Invalida!');
            if($dados['tipoU'] < 1 || $dados['tipoU']>3)
                array_push($argumentos['mensagens'], 'Tipo do Usuario Invalido!');
            if(count($argumentos['mensagens']) == 0){
                $user = new Usuario(
                    null,
                    /*nome*/$dados['nome'],
                    /*$email*/$dados['email'],
                    null,
                    /*$tipo*/$dados['tipoU']
                );
                if (!empty($dados['pass']) && !is_null($dados['pass']) && $dados['pass'] == $dados['confirm-pass']) {
                    $user->setSenha($dados['pass']);
                    $user->cripografarSenha();
                }
                if (!empty($dados['enviar'])) {
                    $user->setId($dados['enviar']);
                    $db->update(
                        'usuarios',
                        $user->toArray(),
                        [
                            'id' => $user->getId()
                        ]
                    );
                }else{
                    $db->insert(
                        'usuarios',
                        $user->toArray()
                    );
                }
                return $response->withRedirect('/admin/usuarios');
            }else{
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if(isset($args['id'])){
            $argumentos['texto'] = 'Atualizar';
            $argumentos['usuario'] = $db->select("usuarios",[
                'id',
                'nome',
                'email',
                'tipo',
            ],
            [
                'id'=>$args['id']
            ])[0];
        }else{
            $argumentos['texto'] = 'Adicionar';
        }
        unset($db);
        return $this->container->view->render(
            $response,
            'admin/usuarios-modificacoes.html',
            $argumentos
        );
    }

    public function areas($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if (isset($args['id'])) {
            $db->delete(
                "area",
                ["id" => $args['id']]
            );
        }
        $areas = $db->select("area",[
            'id', 'nome', 'descricao'
        ]);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/areas.html',[
            'areas'=>$areas
        ]);
    }
    
    public function areas_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (empty($dados['descricao']) || is_null($dados['descricao']))
                array_push($argumentos['mensagens'], 'Descrição Invalida!');
            if (count($argumentos['mensagens']) == 0) {
                $area = new Area();
                $area->setNome($dados['nome']);
                $area->setDescricao($dados['descricao']);
                if (!empty($dados['enviar'])) {
                    $area->setId($dados['enviar']);
                    $db->update(
                        'area',
                        $area->toArray(),
                        [
                            'id' => $area->getId()
                        ]
                    );
                } else {
                    $db->insert(
                        'area',
                        $area->toArray()
                    );
                }
                return $response->withRedirect('/admin/areas');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['area'] = $db->select(
                "area",
                [
                    'id',
                    'nome',
                    'descricao'
                ],
                [
                    'id' => $args['id']
                ]
            )[0];
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/areas-modificacoes.html',
            $argumentos
        );
    }

    public function noticias($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if (isset($args['id'])) {
            $img = $db->select(
                "noticias",
                'imagem',
                ['id' => $args['id']]
            )[0];
            if (!empty($img) || !is_null($img)){
                $upload = new Upload("uploads/");
                $upload->excluir($img, "noticias/");
            }
            $db->delete(
                "noticias",
                ["id" => $args['id']]
            );
        }
        $noticias = $db->select("noticias", [
            'id',
            'titulo',
            'data',
            'hora'
        ]);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/noticias.html',[
            'noticias' => $noticias
        ]);
    }

    public function noticias_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['titulo']) || is_null($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo Invalido!');
            if (empty($dados['conteudo']) || is_null($dados['conteudo']))
                array_push($argumentos['mensagens'], 'Conteudo Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $noticia = new Noticia();
                $noticia->setTitulo($dados['titulo']);
                $noticia->setConteudo($dados['conteudo']);
                $imagem = $request->getUploadedFiles()['imagem'];
                $upload = new Upload("uploads/");
                if($imagem->getError() === UPLOAD_ERR_OK){
                    $upload->image($_FILES['imagem'], date("d-m-Y-H-i-s"), 'noticias/');
                    $noticia->setImagem($upload->getResult()==true?$upload->getName():'');
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "noticias",
                        'imagem',
                        ['id'=>$dados['enviar']]
                    )[0];
                    if (!empty($noticia->getImagem()) || !is_null($noticia->getImagem()))
                        $upload->excluir($img, "noticias/");
                    $noticia->setId($dados['enviar']);
                    $db->update(
                        'noticias',
                        $noticia->toArray(),
                        [
                            'id' => $noticia->getId()
                        ]
                    );
                } else {
                    $ano = $db->select(
                        "ano",
                        [
                            "id",
                            "nome_ano",
                        ],
                        [
                            "status" => 1
                        ]
                    )[0];
                    $noticia->setAno_id($ano['id']);
                    $noticia->setData(date("Y-m-d"));
                    $noticia->setHora(date("H:i"));
                    $db->insert(
                        'noticias',
                        $noticia->toArray()
                    );
                }
                return $response->withRedirect('/admin/noticias');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['noticia'] = $db->select(
                "noticias",
                [
                    'id',
                    'titulo',
                    'imagem',
                    'conteudo'
                ],
                [
                    'id' => $args['id']
                ]
            )[0];
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/noticias-modificacoes.html',
            $argumentos
        );
    }

    public function editais($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if (isset($args['id'])) {
            $img = $db->select(
                "editais",
                'arquivo',
                ['id' => $args['id']]
            )[0];
            if (!empty($img) || !is_null($img)) {
                $upload = new Upload("uploads/");
                $upload->excluir($img, "editais/");
            }
            $db->delete(
                "editais",
                ["id" => $args['id']]
            );
        }
        $editais = $db->select("editais", [
            'id',
            'nome',
            'descricao',
            'tipo'
        ]);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/editais.html',[
            'editais'=>$editais
        ]);
    }

    public function editais_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (empty($dados['tipo']) || is_null($dados['tipo']))
                array_push($argumentos['mensagens'], 'Tipo Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $edital = new Edital();
                $edital->setNome($dados['nome']);
                $edital->setDescricao($dados['descricao']);
                $edital->setTipo($dados['tipo']);
                $arquivo = $request->getUploadedFiles()['arquivo'];
                if ($arquivo->getError() === UPLOAD_ERR_OK) {
                    $upload = new Upload("uploads/");
                    $upload->file($_FILES['arquivo'], date("d-m-Y-H-i-s"), 'editais/');
                    $edital->setArquivo($upload->getResult() == true ? $upload->getName() : '');
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "editais",
                        'arquivo',
                        ['id' => $dados['enviar']]
                    )[0];
                    if (!empty($edital->getArquivo()) || !is_null($edital->getArquivo()))
                        $upload->excluir($img, "editais/");
                    $edital->setId($dados['enviar']);
                    $db->update(
                        'editais',
                        $edital->toArray(),
                        [
                            'id' => $edital->getId()
                        ]
                    );
                } else {
                    $ano = $db->select(
                        "ano",
                        [
                            "id",
                            "nome_ano",
                        ],
                        [
                            "status" => 1
                        ]
                    )[0];
                    $edital->setAno_id($ano['id']);
                    $db->insert(
                        'editais',
                        $edital->toArray()
                    );
                }
                return $response->withRedirect('/admin/editais');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['edital'] = $db->select(
                "editais",
                [
                    'id',
                    'nome',
                    'arquivo',
                    'tipo',
                    'descricao'
                ],
                [
                    'id' => $args['id']
                ]
            )[0];
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/editais-modificacoes.html',
            $argumentos
        );
    }

    public function paginas($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/paginas.html');
    }

    public function cronogramas($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if (isset($args['id'])) {
            $img = $db->select(
                "cronogramas",
                'imagem',
                ['id' => $args['id']]
            )[0];
            if (!empty($img) || !is_null($img)) {
                $upload = new Upload("uploads/");
                $upload->excluir($img, "cronogramas/");
            }
            $db->delete(
                "cronogramas",
                ["id" => $args['id']]
            );
        }
        $cronogramas = $db->select("cronogramas", [
            'id',
            'dia'
        ]);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/cronogramas.html',[
            'cronogramas'=>$cronogramas
        ]);
    }


    public function cronogramas_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (count($argumentos['mensagens']) == 0) {
                $cronograma = new Cronograma();
                $ano = $db->select(
                    "ano",
                    [
                        "id",
                        "nome_ano",
                    ],
                    [
                        "status" => 1
                    ]
                )[0];
                $cronograma->setDia("{$ano['nome_ano']}-{$dados['mes']}-{$dados['dia']}");
                $imagem = $request->getUploadedFiles()['imagem'];
                $upload = new Upload("uploads/");
                if ($imagem->getError() === UPLOAD_ERR_OK) {
                    $upload->image($_FILES['imagem'], date("d-m-Y-H-i-s"), 'cronogramas/');
                    $cronograma->setImagem($upload->getResult() == true ? $upload->getName() : '');
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "cronogramas",
                        'imagem',
                        ['id' => $dados['enviar']]
                    )[0];
                    if (!empty($cronograma->getImagem()) || !is_null($cronograma->getImagem()))
                        $upload->excluir($img, "cronogramas/");
                    $cronograma->setId($dados['enviar']);
                    $db->update(
                        'cronogramas',
                        $cronograma->toArray(),
                        [
                            'id' => $cronograma->getId()
                        ]
                    );
                } else {
                    $cronograma->setAno_id(
                        $ano['id']
                    );
                    $db->insert(
                        'cronogramas',
                        $cronograma->toArray()
                    );
                }
                return $response->withRedirect('/admin/cronogramas');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['cronograma'] = $db->select(
                "cronogramas",
                [
                    'id',
                    'dia',
                    'imagem'
                ],
                [
                    'id' => $args['id']
                ]
            )[0];
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/cronogramas-modificacoes.html',
            $argumentos
        );
    }

    public function apresentacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if (isset($args['id'])) {
            $db->delete(
                "apresentacoes",
                ["id" => $args['id']]
            );
        }
        $apresentacoes = $db->select(
            "apresentacoes",
            [
                "[><]area" => [
                    "apresentacoes.area_id" => "id"
                ],
                "[><]ano" => [
                    "apresentacoes.ano_id" => "id"
                ],
            ],
            [
                'apresentacoes.id',
                'apresentacoes.nome',
                'apresentacoes.data',
                'apresentacoes.hora',
                'area.nome(area)',
                'ano.nome_ano'
            ],
            [
                "ano.status"=>1
            ]
        );
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/apresentacoes.html',[
            'apresentacoes'=>$apresentacoes
        ]);
    }

    public function apresentacoes_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $apresentacao = new Apresentacao();
                $ano = $db->select(
                    "ano",
                    [
                        "id",
                        "nome_ano",
                    ],
                    [
                        "status" => 1
                    ]
                )[0];
                $apresentacao->setNome($dados['nome']);
                $apresentacao->setArea_id($dados['area']);
                $apresentacao->setData("{$ano['nome_ano']}-{$dados['mes']}-{$dados['dia']}");
                $apresentacao->setHora("{$dados['hora']}:{$dados['minutos']}");
                if (!empty($dados['enviar'])) {
                    $apresentacao->setId($dados['enviar']);
                    $db->update(
                        'apresentacoes',
                        $apresentacao->toArray(),
                        [
                            'id' => $apresentacao->getId()
                        ]
                    );
                } else {
                    $apresentacao->setAno_id($ano['id']);
                    $db->insert(
                        'apresentacoes',
                        $apresentacao->toArray()
                    );
                }
                return $response->withRedirect('/admin/apresentacoes');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['apresentacao'] = $db->select(
                "apresentacoes",
                [
                    'id',
                    'nome',
                    'data',
                    'hora',
                    'area_id'
                ],
                [
                    'id' => $args['id']
                ]
            )[0];
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
        $argumentos["areas"]=$db->select("area",[
            "id",
            "nome"
        ]);
        $argumentos["meses"]=[
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ];
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/apresentacoes-modificacoes.html',
            $argumentos
        );
    }

    public function mini_cursos($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if (isset($args['id'])) {
            $db->delete(
                "mini_cursos",
                ["id" => $args['id']]
            );
        }
        $mini_cursos = $db->select(
            "mini_cursos",
            [
                "[><]area" => [
                    "mini_cursos.area_id" => "id"
                ],
                "[><]ano" => [
                    "mini_cursos.ano_id" => "id"
                ],
            ],
            [
                'mini_cursos.id',
                'mini_cursos.nome',
                'mini_cursos.data',
                'mini_cursos.hora',
                'area.nome(area)',
                'ano.nome_ano'
            ],
            [
                "ano.status"=>1
            ]
        );
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/mini_cursos.html',[
            'mini_cursos'=>$mini_cursos
        ]);
    }

    public function mini_cursos_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $mini_cursos = new MiniCurso();
                $ano = $db->select(
                    "ano",
                    [
                        "id",
                        "nome_ano",
                    ],
                    [
                        "status" => 1
                    ]
                )[0];
                $mini_cursos->setNome($dados['nome']);
                $mini_cursos->setArea_id($dados['area']);
                $mini_cursos->setData("{$ano['nome_ano']}-{$dados['mes']}-{$dados['dia']}");
                $mini_cursos->setHora("{$dados['hora']}:{$dados['minutos']}");
                if (!empty($dados['enviar'])) {
                    $mini_cursos->setId($dados['enviar']);
                    $db->update(
                        'mini_cursos',
                        $mini_cursos->toArray(),
                        [
                            'id' => $mini_cursos->getId()
                        ]
                    );
                } else {
                    $mini_cursos->setAno_id($ano['id']);
                    $db->insert(
                        'mini_cursos',
                        $mini_cursos->toArray()
                    );
                }
                return $response->withRedirect('/admin/mini_cursos');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['mini_curso'] = $db->select(
                "mini_cursos",
                [
                    'id',
                    'nome',
                    'data',
                    'hora',
                    'area_id',
                ],
                [
                    'id' => $args['id']
                ]
            )[0];
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
        $argumentos["areas"] = $db->select("area", [
            "id",
            "nome"
        ]);
        $argumentos["meses"] = [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ];
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/mini-cursos-modificacoes.html',
            $argumentos
        );
    }

    public function palestras($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if (isset($args['id'])) {
            $db->delete(
                "palestras",
                ["id" => $args['id']]
            );
        }
        $palestras = $db->select(
            "palestras",
            [
                "[><]area" => [
                    "palestras.area_id" => "id"
                ],
                "[><]ano" => [
                    "palestras.ano_id" => "id"
                ],
            ],
            [
                'palestras.id',
                'palestras.nome',
                'palestras.data',
                'palestras.hora',
                'area.nome(area)',
                'ano.nome_ano'
            ],
            [
                "ano.status" => 1
            ]
        );
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/palestras.html',[
            'palestras'=>$palestras
        ]);
    }

    public function palestras_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $palestra = new Palestra();
                $ano = $db->select(
                    "ano",
                    [
                        "id",
                        "nome_ano",
                    ],
                    [
                        "status" => 1
                    ]
                )[0];
                $palestra->setNome($dados['nome']);
                $palestra->setArea_id($dados['area']);
                $palestra->setData("{$ano['nome_ano']}-{$dados['mes']}-{$dados['dia']}");
                $palestra->setHora("{$dados['hora']}:{$dados['minutos']}");
                if (!empty($dados['enviar'])) {
                    $palestra->setId($dados['enviar']);
                    $db->update(
                        'palestras',
                        $palestra->toArray(),
                        [
                            'id' => $palestra->getId()
                        ]
                    );
                } else {
                    $palestra->setAno_id($ano['id']);
                    $db->insert(
                        'palestras',
                        $palestra->toArray()
                    );
                }
                return $response->withRedirect('/admin/palestras');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['palestra'] = $db->select(
                "palestras",
                [
                    'id',
                    'nome',
                    'data',
                    'hora',
                    'area_id',
                ],
                [
                    'id' => $args['id']
                ]
            )[0];
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
        $argumentos["areas"] = $db->select("area", [
            "id",
            "nome"
        ]);
        $argumentos["meses"] = [
            "Janeiro",
            "Fevereiro",
            "Março",
            "Abril",
            "Maio",
            "Junho",
            "Julho",
            "Agosto",
            "Setembro",
            "Outubro",
            "Novembro",
            "Dezembro"
        ];
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/palestras-modificacoes.html',
            $argumentos
        );
    }
    
    public function anos($request, $response, $args)
    {
        Login::verifyLogin();
        $db = $this->container->db;
        if (isset($args['id'])) {
            $db->delete(
                "ano",
                ["id" => $args['id']]
            );
        }
        $anos = $db->select(
            "ano",
            ['id', 'nome_ano', 'status'],
            [
                "ORDER" => [
                    'nome_ano' => "DESC"
                ]
            ]
        );
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/anos.html',[
            'anos' => $anos
        ]);
    }

    public function anos_modificacoes($request, $response, $args)
    {
        Login::verifyLogin();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['ano']) || is_null($dados['ano']) || $dados['ano']<2000 || $dados['ano']>2100)
                array_push($argumentos['mensagens'], 'Ano Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $ano = new Ano();
                $ano->setNome_ano($dados['ano']);
                $ano->setStatus($dados['status']);
                $ano->setEditais($dados['editais']);
                $ano->setCronogramas($dados['cronogramas']);
                $ano->setNoticias($dados['noticias']);
                $ano->setPalestras($dados['palestras']);
                $ano->setApresentacoes($dados['apresentacoes']);
                if (!empty($dados['enviar'])) {
                    $ano->setId($dados['enviar']);
                    $db->update(
                        'ano',
                        $ano->toArray(),
                        [
                            'id' => $ano->getId()
                        ]
                    );
                } else {
                    $db->insert(
                        'ano',
                        $ano->toArray()
                    );
                }
                return $response->withRedirect('/admin/anos');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['ano'] = $db->select(
                "ano",
                [
                    'id',
                    'nome_ano',
                    'status',
                    'editais',
                    'cronogramas',
                    'noticias',
                    'palestras',
                    'apresentacoes'
                ],
                [
                    'id' => $args['id']
                ]
            )[0];
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
        $argumentos['ano_atual'] = date("Y");
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/anos-modificacoes.html',
            $argumentos
        );
    }

    public function conta($request, $response, $args)
    {
        Login::verifyLogin();
        //TODO: primeiro fazer o login
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL))
                array_push($argumentos['mensagens'], 'Email Invalido!');
            if (($dados['pass'] != $dados['confirm-pass'] || empty($dados['pass']) || is_null($dados['pass'])))
                array_push($argumentos['mensagens'], 'Senha Invalida!');
            if (count($argumentos['mensagens']) == 0) {
                $user = new Usuario(
                    null,
                    /*nome*/
                    $dados['nome'],
                    /*$email*/
                    $dados['email'],
                    null,
                    /*$tipo*/
                    $dados['tipoU']
                );
                if (!empty($dados['pass']) && !is_null($dados['pass']) && $dados['pass'] == $dados['confirm-pass']) {
                    $user->setSenha($dados['pass']);
                    $user->cripografarSenha();
                }
                if (!empty($dados['enviar'])) {
                    $user->setId($dados['enviar']);
                    $db->update(
                        'usuarios',
                        $user->toArray(),
                        [
                            'id' => $user->getId()
                        ]
                    );
                } else {
                    $db->insert(
                        'usuarios',
                        $user->toArray()
                    );
                }
                return $response->withRedirect('/admin/cpnta');
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        $argumentos['usuario'] = $db->select("usuarios", [
            'id', 'nome', 'email'
        ],[
            'id'=>'1'
        ])[0];
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/conta.html', $argumentos);
    }

    public function sair($request, $response, $args)
    {
        Login::logout();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $response->withStatus(200)->withHeader('Location', $this->container->router->urlFor("login-admin"));
    }

    public function template($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/template/'.$args['nome']);
    }
}
