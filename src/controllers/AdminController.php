<?php

namespace app\controllers;

use app\models\Ano;
use app\models\Apresentacao;
use app\models\Area;
use app\models\Cronograma;
use app\models\Calendario;
use app\models\Edital;
use app\models\CursoOficina;
use app\models\Noticia;
use app\models\Palestra;
use app\models\Artistico;
use app\models\Usuario;
use app\helpers\Upload;
use app\helpers\Login;
use app\helpers\Password;

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
        Login::redirectLogin($this->container->router->pathFor('dashboard-admin'));
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
            return $response->withRedirect($this->container->router->pathFor('dashboard-admin'));
        }
        return $this->container->view->render($response, 'admin/login.html');
    }

    public function dashboard($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $db = $this->container->db;
        $argumentos = [];
        $argumentos['usuarios']=$db->count(
            "usuarios"
        );
        $argumentos['apresentacoes']=$db->count(
            "apresentacoes"
        );
        $argumentos['cursos_oficinas']=$db->count(
            "cursos_oficinas"
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response);
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
            'usuarios'=>$usuarios,
            'idlogado' => $_SESSION['id']
        ]);
    }
    
    public function usuarios_modificacoes($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response);
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
                return $response->withRedirect($this->container->router->pathFor('usuarios-admin'));
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
        $argumentos['idlogado'] = $_SESSION['id'];
        unset($db);
        return $this->container->view->render(
            $response,
            'admin/usuarios-modificacoes.html',
            $argumentos
        );
    }

    public function areas($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
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
                return $response->withRedirect($this->container->router->pathFor('areas-admin'));
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['titulo']) || is_null($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo Invalido!');
            if (empty($dados['subtitulo']) || is_null($dados['subtitulo']))
                array_push($argumentos['mensagens'], 'Sub Titulo Invalido!');
            if (empty($dados['conteudo']) || is_null($dados['conteudo']))
                array_push($argumentos['mensagens'], 'Conteudo Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $noticia = new Noticia();
                $noticia->setTitulo($dados['titulo']);
                $noticia->setSubTitulo($dados['subtitulo']);
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
                return $response->withRedirect($this->container->router->pathFor('noticias-admin'));
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
                    'subtitulo',
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response, 2);
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response, 2);
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
            $arquivo = $request->getUploadedFiles()['arquivo'];
            $edital = new Edital();
            if ($arquivo->getError() === UPLOAD_ERR_OK) {
                $upload = new Upload("uploads/");
                $upload->file($_FILES['arquivo'], date("d-m-Y-H-i-s"), 'editais/', 5);
                if($upload->getResult())
                    $edital->setArquivo($upload->getResult() == true ? $upload->getName() : '');
                else
                    array_push($argumentos['mensagens'], $upload->getMsg());
            }else if ($arquivo->getError() === UPLOAD_ERR_INI_SIZE){
                array_push($argumentos['mensagens'], "Arquivo muito grande!");
            }
            if (count($argumentos['mensagens']) == 0) {
                $edital->setNome($dados['nome']);
                $edital->setDescricao($dados['descricao']);
                $edital->setTipo($dados['tipo']);
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
                return $response->withRedirect($this->container->router->pathFor('editais-admin'));
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/paginas.html');
    }

    public function cronogramas($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response, 2);
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response, 2);
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
                return $response->withRedirect($this->container->router->pathFor('cronogramas-admin'));
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

    public function calendario($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response, 2);
        $db = $this->container->db;
        if (isset($args['id'])) {
            $db->delete(
                "calendario",
                ["id" => $args['id']]
            );
        }
        $calendario = $db->select("calendario", [
            'id',
            'data'
        ]);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/calendario.html', [
            'calendario' => $calendario
        ]);
    }

    public function calendario_modificacoes($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response, 2);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['data']) || is_null($dados['data']))
                array_push($argumentos['mensagens'], 'Data Invalida!');
            if (empty($dados['descricao']) || is_null($dados['descricao']))
                array_push($argumentos['mensagens'], 'Descrição Invalida!');
            if (count($argumentos['mensagens']) == 0) {
                $calendario = new Calendario();
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
                $calendario->setData($dados['data']);
                $calendario->setDescricao($dados['descricao']);
                if (!empty($dados['enviar'])) {
                    $calendario->setId($dados['enviar']);
                    $db->update(
                        'calendario',
                        $calendario->toArray(),
                        [
                            'id' => $calendario->getId()
                        ]
                    );
                } else {
                    $calendario->setAno_id(
                        $ano['id']
                    );
                    $db->insert(
                        'calendario',
                        $calendario->toArray()
                    );
                }
                return $response->withRedirect($this->container->router->pathFor('calendario-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['calendario'] = $db->select(
                "calendario",
                [
                    'id',
                    'data',
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
            'admin/calendario-modificacoes.html',
            $argumentos
        );
    }

    public function apresentacoes($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
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
                'apresentacoes.resumo',
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
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
                $apresentacao->setResumo($dados['resumo']);
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
                return $response->withRedirect($this->container->router->pathFor('apresentacoes-admin'));
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
                    'resumo',
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

    public function cursos_oficinas($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $db = $this->container->db;
        if (isset($args['id'])) {
            $img = $db->select(
                "cursos_oficinas",
                'imagem',
                ['id' => $args['id']]
            )[0];
            if (!empty($img) || !is_null($img))
                (new Upload("uploads/"))->excluir($img, "cursos_oficinas/");
            $db->delete(
                "cursos_oficinas",
                ["id" => $args['id']]
            );
        }
        $cursos_oficinas = $db->select(
            "cursos_oficinas",
            [
                "[><]area" => [
                    "cursos_oficinas.area_id" => "id"
                ],
                "[><]ano" => [
                    "cursos_oficinas.ano_id" => "id"
                ],
            ],
            [
                'cursos_oficinas.id',
                'cursos_oficinas.titulo',
                'cursos_oficinas.tipo',
                'area.nome(area)',
                'ano.nome_ano'
            ],
            [
                "ano.status"=>1
            ]
        );

        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/cursos_oficinas.html',[
            'cursos_oficinas'=>$cursos_oficinas
        ]);
    }

    public function cursos_oficinas_modificacoes($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['titulo']) || is_null($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo Invalido!');
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (empty($dados['data']) || is_null($dados['data']))
                array_push($argumentos['mensagens'], 'Data Invalida!');
            if (empty($dados['sala']) || is_null($dados['sala']))
                array_push($argumentos['mensagens'], 'Sala Invalida!');
            if (empty($dados['resumo']) || is_null($dados['resumo']))
                array_push($argumentos['mensagens'], 'Resumo Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $cursos_oficinas = new CursoOficina();
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
                $cursos_oficinas->setTitulo($dados['titulo']);
                $cursos_oficinas->setNome($dados['nome']);
                $cursos_oficinas->setResumo($dados['resumo']);
                $cursos_oficinas->setSala($dados['sala']);
                $cursos_oficinas->setArea_id($dados['area']);
                $cursos_oficinas->setTipo($dados['tipo']);
                $cursos_oficinas->setData($dados['data']);
                $imagem = $request->getUploadedFiles()['imagem'];
                $upload = new Upload("uploads/");
                if ($imagem->getError() === UPLOAD_ERR_OK) {
                    $upload->image($_FILES['imagem'], date("d-m-Y-H-i-s"), 'cursos_oficinas/');
                    $cursos_oficinas->setImagem($upload->getResult() == true ? $upload->getName() : '');
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "cursos_oficinas",
                        'imagem',
                        ['id' => $dados['enviar']]
                    )[0];
                    if (!empty($cursos_oficinas->getImagem()) || !is_null($cursos_oficinas->getImagem()))
                        $upload->excluir($img, "cursos_oficinas/");
                    $cursos_oficinas->setId($dados['enviar']);
                    $db->update(
                        'cursos_oficinas',
                        $cursos_oficinas->toArray(),
                        [
                            'id' => $cursos_oficinas->getId()
                        ]
                    );
                } else {
                    $cursos_oficinas->setAno_id($ano['id']);
                    $db->insert(
                        'cursos_oficinas',
                        $cursos_oficinas->toArray()
                    );
                }
                return $response->withRedirect($this->container->router->pathFor('cursos_oficinas-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['curso_oficina'] = $db->select(
                "cursos_oficinas",
                [
                    'id',
                    'titulo',
                    'nome',
                    'data',
                    'resumo',
                    'sala',
                    'tipo',
                    'imagem',
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
            'admin/cursos_oficinas-modificacoes.html',
            $argumentos
        );
    }

    public function palestras($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $db = $this->container->db;
        if (isset($args['id'])) {
            $img = $db->select(
                "palestras",
                'imagem',
                ['id' => $args['id']]
            )[0];
            if (!empty($img) || !is_null($img)) (new Upload("uploads/"))->excluir($img, "palestras/");
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
                'palestras.titulo',
                'palestras.data',
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['titulo']) || is_null($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo Invalido!');
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (empty($dados['data']) || is_null($dados['data']))
                array_push($argumentos['mensagens'], 'Data Invalida!');
            if (empty($dados['sala']) || is_null($dados['sala']))
                array_push($argumentos['mensagens'], 'Sala Invalida!');
            if (empty($dados['resumo']) || is_null($dados['resumo']))
                array_push($argumentos['mensagens'], 'Resumo Invalido!');
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
                $palestra->setTitulo($dados['titulo']);
                $palestra->setNome($dados['nome']);
                $palestra->setResumo($dados['resumo']);
                $palestra->setSala($dados['sala']);
                $palestra->setArea_id($dados['area']);
                $palestra->setData($dados['data']);
                $imagem = $request->getUploadedFiles()['imagem'];
                $upload = new Upload("uploads/");
                if ($imagem->getError() === UPLOAD_ERR_OK) {
                    $upload->image($_FILES['imagem'], date("d-m-Y-H-i-s"), 'palestras/');
                    $palestra->setImagem($upload->getResult() == true ? $upload->getName() : '');
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "palestras",
                        'imagem',
                        ['id' => $dados['enviar']]
                    )[0];
                    if (!empty($palestra->getImagem()) || !is_null($palestra->getImagem()))
                        $upload->excluir($img, "palestras/");
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
                return $response->withRedirect($this->container->router->pathFor('palestras-admin'));
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
                    'titulo',
                    'nome',
                    'data',
                    'resumo',
                    'sala',
                    'imagem',
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

    public function artistico($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $db = $this->container->db;
        if (isset($args['id'])) {
            $img = $db->select(
                "artistico",
                'imagem',
                ['id' => $args['id']]
            )[0];
            if (!empty($img) || !is_null($img)) (new Upload("uploads/"))->excluir($img, "artistico/");
            $db->delete(
                "artistico",
                ["id" => $args['id']]
            );
        }
        $artistico = $db->select(
            "artistico",
            [
                "[><]area" => [
                    "artistico.area_id" => "id"
                ],
                "[><]ano" => [
                    "artistico.ano_id" => "id"
                ],
            ],
            [
                'artistico.id',
                'artistico.titulo',
                'artistico.tipo',
                'area.nome(area)',
                'ano.nome_ano'
            ],
            [
                "ano.status" => 1
            ]
        );
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/artistico.html', [
            'artisticas' => $artistico
        ]);
    }

    public function artistico_modificacoes($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['titulo']) || is_null($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo Invalido!');
            if (empty($dados['facilitador']) || is_null($dados['facilitador']))
                array_push($argumentos['mensagens'], 'Facilitador Invalido!');
            if (empty($dados['data']) || is_null($dados['data']))
                array_push($argumentos['mensagens'], 'Data Invalida!');
            if (empty($dados['local']) || is_null($dados['local']))
                array_push($argumentos['mensagens'], 'Local Invalida!');
            if (empty($dados['resumo']) || is_null($dados['resumo']))
                array_push($argumentos['mensagens'], 'Resumo Invalido!');
            if (count($argumentos['mensagens']) == 0) {
                $palestra = new Artistico();
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
                $palestra->setTitulo($dados['titulo']);
                $palestra->setFacilitador($dados['facilitador']);
                $palestra->setResumo($dados['resumo']);
                $palestra->setLocal($dados['local']);
                $palestra->setArea_id($dados['area']);
                $palestra->setTipo($dados['tipo']);
                $palestra->setData($dados['data']);
                $imagem = $request->getUploadedFiles()['imagem'];
                $upload = new Upload("uploads/");
                if ($imagem->getError() === UPLOAD_ERR_OK) {
                    $upload->image($_FILES['imagem'], date("d-m-Y-H-i-s"), 'artistico/');
                    $palestra->setImagem($upload->getResult() == true ? $upload->getName() : '');
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "artistico",
                        'imagem',
                        ['id' => $dados['enviar']]
                    )[0];
                    if (!empty($palestra->getImagem()) || !is_null($palestra->getImagem()))
                        $upload->excluir($img, "artistico/");
                    $palestra->setId($dados['enviar']);
                    $db->update(
                        'artistico',
                        $palestra->toArray(),
                        [
                            'id' => $palestra->getId()
                        ]
                    );
                } else {
                    $palestra->setAno_id($ano['id']);
                    $db->insert(
                        'artistico',
                        $palestra->toArray()
                    );
                }
                return $response->withRedirect($this->container->router->pathFor('artistico-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['texto'] = 'Atualizar';
            $argumentos['artistico'] = $db->select(
                "artistico",
                [
                    'id',
                    'titulo',
                    'facilitador',
                    'data',
                    'tipo',
                    'resumo',
                    'local',
                    'imagem',
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
        unset($db);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render(
            $response,
            'admin/artistico-modificacoes.html',
            $argumentos
        );
    }
    
    public function anos($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response);
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
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response);
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
                return $response->withRedirect($this->container->router->pathFor('anos-admin'));
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

    public function removeViews($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response);
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

    public function conta($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
            if (empty($dados['nome']) || is_null($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome Invalido!');
            if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL))
                array_push($argumentos['mensagens'], 'Email Invalido!');
            if (($dados['new-pass'] != $dados['confirm-pass'] ||
                 $dados['pass'] == $dados['new-pass'] || 
                 empty($dados['new-pass']) || is_null($dados['new-pass']) ||
                 empty($dados['pass']) || is_null($dados['pass'])))
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
                    null
                );
                if (!empty($dados['new-pass']) && !is_null($dados['new-pass']) && $dados['new-pass'] == $dados['confirm-pass']) {
                    $user->setSenha($dados['new-pass']);
                    $user->cripografarSenha();
                }
                if (!empty($dados['enviar'])) {
                    $user->setId($dados['enviar']);
                    $db->update(
                        'usuarios',
                        $user->toArray(),
                        [
                            'id' => $user->getId(),
                            'senha' => (new Password())->hash_pass($dados['pass'])
                        ]
                    );
                }
                return $response->withRedirect($this->container->router->pathFor('dashboard-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        $argumentos['usuario'] = $db->select("usuarios", [
            'id', 'nome', 'email'
        ],[
            'id'=> $_SESSION['id']
        ])[0];
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/conta.html', $argumentos);
    }

    public function sair($request, $response, $args)
    {
        Login::logout();
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $response->withStatus(200)->withHeader('Location', $this->container->router->pathFor("login-admin"));
    }
}
