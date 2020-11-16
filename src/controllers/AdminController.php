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

use GuzzleHttp;

class AdminController
{
    protected $container;
    protected $ano_atual;

    // constructor receives container instance
    public function __construct($container)
    {
        $this->container = $container;
        $this->ano_atual = $container->db->select(
            "ano",
            [
                "id",
                "nome_ano",
                "id_evento",
            ],
            [
                "status" => 1
            ]
        )[0];
    }

    public function login($request, $response, $args)
    {
        Login::redirectLogin($this->container->router->pathFor('dashboard-admin'));
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        $loginResponse = true;
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
            $loginResponse = $login->logar();
            
            # Tentar redirecionar para o dashboard somente se o login foi realizado
            if ($loginResponse)
                return $response->withRedirect($this->container->router->pathFor('dashboard-admin'));
        }
        return $this->container->view->render($response, 'admin/login.html',[
            'loginResponse' => $loginResponse
        ]);
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
            "apresentacoes",
            [
                "ano_id" => $this->ano_atual['id']
            ]
        );
        $argumentos['cursos_oficinas']=$db->count(
            "cursos_oficinas",
            [
                "ano_id" => $this->ano_atual['id']
            ]
        );
        $argumentos['palestras']=$db->count(
            "palestras",
            [
                "ano_id" => $this->ano_atual['id']
            ]
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

            # Validação do nome
            if (empty($dados['nome']) || is_null($dados['nome']) || is_numeric($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome inválido!');
            else if (strlen($dados['nome']) <= 3)
                array_push($argumentos['mensagens'], 'Nome deve ter mais de 3 caracteres!');
            
            # Validação do e-mail
            $emailsIguais = $db->count('usuarios', [
                'email' => $dados['email'],
                'id[!]' => $args['id']
            ]);

            if(!filter_var($dados['email'], FILTER_VALIDATE_EMAIL))
                array_push($argumentos['mensagens'], 'Email inválido!');
            else if($emailsIguais > 0)
                array_push($argumentos['mensagens'], 'Email já cadastrado por outro usuário!');

            # Validação de senha
            if(empty($dados['enviar']) && ($dados['pass'] != $dados['confirm-pass'] || empty($dados['pass']) || is_null($dados['pass'])))
                array_push($argumentos['mensagens'], 'Senha inválida!');

            # Validação do tipo de usuário
            if($dados['tipoU'] < 1 || $dados['tipoU']>3)
                array_push($argumentos['mensagens'], 'Tipo do Usuario inválido!');
            
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

                    $this->container->flash->addMessage('usuarios', 'Usuário atualizado com sucesso!');
                }else{
                    $db->insert(
                        'usuarios',
                        $user->toArray()
                    );
                    $this->container->flash->addMessage('usuarios', 'Usuário adicionado com sucesso!');
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

            $nomesIguais = $db->count('area', [
                'nome' => $dados['nome'],
                'id[!]' => $args['id']
            ]);

            # Validação do nome
            if (empty($dados['nome']) || is_null($dados['nome']) || is_numeric($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome inválido!');
            else if(strlen($dados['nome']) < 5)
                array_push($argumentos['mensagens'], 'Nome deve ter no mínimo 5 caracteres!');
            else if($nomesIguais > 0)
                array_push($argumentos['mensagens'], 'Já existe uma área com esse nome!');

            # Validação da descricação
            if (empty($dados['descricao']) || is_null($dados['descricao']) || is_numeric($dados['descricao']))
                array_push($argumentos['mensagens'], 'Descrição inválida!');
            
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
                    $this->container->flash->addMessage('areas', 'Área atualizada com sucesso!');
                } else {
                    $db->insert(
                        'area',
                        $area->toArray()
                    );
                    $this->container->flash->addMessage('areas', 'Área adicionada com sucesso!');
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
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if (!empty($img) || !is_null($img)){
                $upload = new Upload("uploads/");
                $upload->excluir($img, "noticias/");
            }
            $db->delete(
                "noticias",
                [
                    "id" => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            );
        }
        $noticias = $db->select(
            "noticias", 
            [
                'id',
                'titulo',
                'data',
                'hora'
            ],
            [
                "ano_id" => $this->ano_atual['id']
            ]
        );
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

            # Validação do titulo
            if (empty($dados['titulo']) || is_null($dados['titulo']) || is_numeric($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo inválido!');
            else if(strlen($dados['titulo']) < 8)
                array_push($argumentos['mensagens'], 'Título deve ter no mínimo 8 caracteres!');
            
            # Validação do subtitulo
            if (empty($dados['subtitulo']) || is_null($dados['subtitulo']) || is_numeric($dados['subtitulo'])) 
                array_push($argumentos['mensagens'], 'Sub Titulo inválido!');
            else if(strlen($dados['subtitulo']) < 5)
                array_push($argumentos['mensagens'], 'Sub Título deve ter no mínimo 5 caracteres!');
            
            # Validação do conteúdo
            if (empty($dados['conteudo']) || is_null($dados['conteudo']))
                array_push($argumentos['mensagens'], 'Conteúdo não pode ser vazio!');
            
            # Validação da descrição da imagem
            if ((empty($dados['imagem_descricao']) || is_null($dados['imagem_descricao'])) && 
                $request->getUploadedFiles()['imagem']->getError() != UPLOAD_ERR_NO_FILE)
                array_push($argumentos['mensagens'], 'Descrição da Imagem Invalida!');

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
                    $noticia->setImagem_descricao($dados['imagem_descricao']);
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "noticias",
                        'imagem',
                        [
                            'id'=>$dados['enviar'],
                            "ano_id" => $this->ano_atual['id']
                        ]
                    )[0];
                    if (!empty($noticia->getImagem()) || !is_null($noticia->getImagem()))
                        $upload->excluir($img, "noticias/");
                    $noticia->setId($dados['enviar']);
                    $db->update(
                        'noticias',
                        $noticia->toArray(),
                        [
                            'id' => $noticia->getId(),
                            "ano_id" => $this->ano_atual['id']
                        ]
                    );
                    $this->container->flash->addMessage('noticias', 'Notícia atualizada com sucesso!');
                } else {
                    $noticia->setAno_id($this->ano_atual['id']);
                    $noticia->setData(date("Y-m-d"));
                    $noticia->setHora(date("H:i"));
                    $db->insert(
                        'noticias',
                        $noticia->toArray()
                    );
                    $this->container->flash->addMessage('noticias', 'Notícia adicionada com sucesso!');
                }
                return $response->withRedirect($this->container->router->pathFor('noticias-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['noticia'] = $db->select(
                "noticias",
                [
                    'id',
                    'titulo',
                    'subtitulo',
                    'imagem',
                    'conteudo',
                    'imagem_descricao'
                ],
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if ($argumentos['noticia'])
                $argumentos['texto'] = 'Atualizar';
            else
                $argumentos['texto'] = 'Adicionar';
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
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if (!empty($img) || !is_null($img)) {
                $upload = new Upload("uploads/");
                $upload->excluir($img, "editais/");
            }
            $db->delete(
                "editais",
                [
                    "id" => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            );
        }
        $editais = $db->select(
            "editais", 
            [
                'id',
                'nome',
                'descricao',
                'tipo'
            ],
            [
                "ano_id" => $this->ano_atual['id']
            ]
        );
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

            # Validação do nome
            $nomesIguais = $db->count('editais', [
                'nome' => $dados['nome'],
                'id[!]' => $args['id']
            ]);
            if (empty($dados['nome']) || is_null($dados['nome']) || is_numeric($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome inválido!');
            else if (strlen($dados['nome']) < 5)
                array_push($argumentos['mensagens'], 'Nome deve ter no mínimo 5 caracteres!');
            else if ($nomesIguais)
                array_push($argumentos['mensagens'], 'Já existe um edital cadastrado com esse nome!');

            # Validação do tipo
            if (empty($dados['tipo']) || is_null($dados['tipo']) || is_numeric($dados['tipo']))
                array_push($argumentos['mensagens'], 'Tipo inválido!');
            else if (strlen($dados['tipo']) < 5)
                array_push($argumentos['mensagens'], 'Tipo deve ter no mínimo 5 caracteres!');
            
            # Validação da descrição
            if (empty($dados['descricao']) || is_null($dados['descricao']) || is_numeric($dados['descricao']))
                array_push($argumentos['mensagens'], 'Descrição inválido!');

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
                        [
                            'id' => $dados['enviar'],
                            "ano_id" => $this->ano_atual['id']
                        ]
                    )[0];
                    if (!empty($edital->getArquivo()) || !is_null($edital->getArquivo()))
                        $upload->excluir($img, "editais/");
                    $edital->setId($dados['enviar']);
                    $db->update(
                        'editais',
                        $edital->toArray(),
                        [
                            'id' => $edital->getId(),
                            "ano_id" => $this->ano_atual['id']
                        ]
                    );

                    $this->container->flash->addMessage('editais', 'Edital atualizado com sucesso!');
                } else {
                    $edital->setAno_id($this->ano_atual['id']);
                    $db->insert(
                        'editais',
                        $edital->toArray()
                    );
                    $this->container->flash->addMessage('editais', 'Edital adicionado com sucesso!');
                }
                return $response->withRedirect($this->container->router->pathFor('editais-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
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
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if($argumentos['edital'])
                $argumentos['texto'] = 'Atualizar';
            else
                $argumentos['texto'] = 'Adicionar';
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

    public function cronogramas($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        Login::permitAccess($request, $response, 2);
        $db = $this->container->db;
        if (isset($args['id'])) {
            $img = $db->select(
                "cronogramas",
                'imagem',
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if (!empty($img) || !is_null($img)) {
                $upload = new Upload("uploads/");
                $upload->excluir($img, "cronogramas/");
            }
            $db->delete(
                "cronogramas",
                [
                    "id" => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            );
        }
        $cronogramas = $db->select("cronogramas", [
            'id',
            'dia'
        ],[
            "ano_id" => $this->ano_atual['id']
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
                $cronograma->setDia("{$this->ano_atual['nome_ano']}-{$dados['mes']}-{$dados['dia']}");
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
                        [
                            'id' => $dados['enviar'],
                            "ano_id" => $this->ano_atual['id']
                        ]
                    )[0];
                    if (!empty($cronograma->getImagem()) || !is_null($cronograma->getImagem()))
                        $upload->excluir($img, "cronogramas/");
                    $cronograma->setId($dados['enviar']);
                    $db->update(
                        'cronogramas',
                        $cronograma->toArray(),
                        [
                            'id' => $cronograma->getId(),
                            "ano_id" => $this->ano_atual['id']
                        ]
                    );
                    $this->container->flash->addMessage('cronogramas', 'Cronograma atualizado com sucesso!');
                } else {
                    $cronograma->setAno_id(
                        $this->ano_atual['id']
                    );
                    $db->insert(
                        'cronogramas',
                        $cronograma->toArray()
                    );
                    $this->container->flash->addMessage('cronogramas', 'Cronograma adicionado com sucesso!');
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
                [
                    "id" => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            );
        }
        $calendario = $db->select("calendario", [
            'id',
            'data'
        ],[
            "ano_id" => $this->ano_atual['id']
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

            # Validação da data
            $datasIguais = $db->count('calendario', [
                'data' => $dados['data'],
                'id[!]' => $args['id']
            ]);
            if (empty($dados['data']) || is_null($dados['data']))
                array_push($argumentos['mensagens'], 'Data inválida!');
            else if (strlen($dados['data']) < 4)
                array_push($argumentos['mensagens'], 'Data deve ter no mínimo 4 caracteres!');
            else if($datasIguais > 0)
                array_push($argumentos['mensagens'], 'Essa data já foi cadastrada!');

            # Validação da descrição
            if (empty($dados['descricao']) || is_null($dados['descricao']) || is_numeric($dados['descricao']))
                array_push($argumentos['mensagens'], 'Descrição inválida!');
            else if (strlen($dados['descricao']) < 5)
                array_push($argumentos['mensagens'], 'Descrição deve ter no mínimo 5 caracteres!');
            

            if (count($argumentos['mensagens']) == 0) {
                $calendario = new Calendario();
                $calendario->setData($dados['data']);
                $calendario->setDescricao($dados['descricao']);
                if (!empty($dados['enviar'])) {
                    $calendario->setId($dados['enviar']);
                    $db->update(
                        'calendario',
                        $calendario->toArray(),
                        [
                            'id' => $calendario->getId(),
                            "ano_id" => $this->ano_atual['id']
                        ]
                    );

                    $this->container->flash->addMessage('calendario', 'Dia atualizado com sucesso!');
                } else {
                    $calendario->setAno_id(
                        $this->ano_atual['id']
                    );
                    $db->insert(
                        'calendario',
                        $calendario->toArray()
                    );

                    $this->container->flash->addMessage('calendario', 'Dia cadastrado com sucesso!');
                }
                return $response->withRedirect($this->container->router->pathFor('calendario-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['calendario'] = $db->select(
                "calendario",
                [
                    'id',
                    'data',
                    'descricao'
                ],
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if($argumentos['calendario'])
                $argumentos['texto'] = 'Atualizar';
            else
                $argumentos['texto'] = 'Adicionar';
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
                [
                    "id" => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            );
        }
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
                'apresentacoes.trilha',
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

    public function apresentacoes_buscar($request, $response, $args)
    {
        Login::verifyLogin($this->container->router->pathFor('login-admin'));
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $api = str_replace("{id_evento}", $this->ano_atual['id_evento'], $this->container->api);
        $client = new GuzzleHttp\Client(['http_errors' => false]);
        $res = $client->request('GET', $api);
        $statusCode = $res->getStatusCode();
        switch ($statusCode) {
            case 200:
                $data = json_decode($res->getBody());
                $apresentacao = new Apresentacao();
                $apresentacao->setAno_id($this->ano_atual['id']);
                foreach ($data as $trabalho) {
                    $apresentacao->setNome($trabalho->tituloTrabalho);
                    $apresentacao->setAutor($trabalho->nomeAutor);
                    $apresentacao->setTrilha($trabalho->nomeTrilha);
                    $apresentacao->setResumo($trabalho->resumo);
                    $apresentacao->setIdFake($trabalho->idFake);
                    $db->insert(
                        'apresentacoes',
                        $apresentacao->toArray(true)
                    );
                }
                $this->container->flash->addMessage('apresentacoes', 'Apresentações cadastradas com sucesso!');
            break;
            default:
                $this->container->flash->addMessage('busca', 'Erro ao Buscar Apresentações!');
            break;
        }
        return $response->withRedirect($this->container->router->pathFor('apresentacoes-admin'));
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

            # Validação do nome
            if (empty($dados['nome']) || is_null($dados['nome']) || is_numeric($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome inválido!');
            else if(strlen($dados['nome']) < 8)
                array_push($argumentos['mensagens'], 'Nome deve ter no mínimo 8 caracteres!');

            # Validação do resumo
            if (empty($dados['resumo']) || is_null($dados['resumo']) || is_numeric($dados['resumo']))
                array_push($argumentos['mensagens'], 'Resumo inválido!');
            else if(strlen($dados['resumo']) < 10)
                array_push($argumentos['mensagens'], 'Resumo deve ter no mínimo 10 caracteres!');
            
            # Validação da trilha
            if (empty($dados['trilha']) || is_null($dados['trilha'])|| is_numeric($dados['trilha']))
                array_push($argumentos['mensagens'], 'Trilha inválida!');

            # Validação do autor
            if (empty($dados['autor']) || is_null($dados['autor'])|| is_numeric($dados['autor']))
                array_push($argumentos['mensagens'], 'Autor inválida!');

            if (count($argumentos['mensagens']) == 0) {
                $apresentacao = new Apresentacao();
                $apresentacao->setNome($dados['nome']);
                $apresentacao->setAutor($dados['autor']);
                $apresentacao->setTrilha($dados['trilha']);
                $apresentacao->setResumo($dados['resumo']);
                if (!empty($dados['enviar'])) {
                    $apresentacao->setId($dados['enviar']);
                    $db->update(
                        'apresentacoes',
                        $apresentacao->toArray(),
                        [
                            'id' => $apresentacao->getId(),
                            "ano_id" => $this->ano_atual['id']
                        ]
                    );

                    $this->container->flash->addMessage('apresentacoes', 'Apresentação atualizada com sucesso!');
                } else {
                    $apresentacao->setAno_id($this->ano_atual['id']);
                    $db->insert(
                        'apresentacoes',
                        $apresentacao->toArray()
                    );
                    $this->container->flash->addMessage('apresentacoes', 'Apresentação adicionada com sucesso!');
                }
                return $response->withRedirect($this->container->router->pathFor('apresentacoes-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
            $argumentos['apresentacao'] = $db->select(
                "apresentacoes",
                [
                    'id',
                    'nome',
                    'resumo',
                    'trilha',
                    'autor'
                ],
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if($argumentos['apresentacao'])
                $argumentos['texto'] = 'Atualizar';
            else
                $argumentos['texto'] = 'Adicionar';
        } else {
            $argumentos['texto'] = 'Adicionar';
        }
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
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if (!empty($img) || !is_null($img))
                (new Upload("uploads/"))->excluir($img, "cursos_oficinas/");
            $db->delete(
                "cursos_oficinas",
                [
                    "id" => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
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

            # Validação do titulo
            if (empty($dados['titulo']) || is_null($dados['titulo']) || is_numeric($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo inválido!');
            else if (strlen($dados['titulo']) < 5)
                array_push($argumentos['mensagens'], 'Titulo deve ter no mínimo 5 caracteres!');

            # Validação do nome
            if (empty($dados['nome']) || is_null($dados['nome']) || is_numeric($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome inválido!');
            else if (strlen($dados['nome']) < 5)
                array_push($argumentos['mensagens'], 'Nome deve ter no mínimo 5 caracteres!');

            # Validação da sala
            if (empty($dados['sala']) || is_null($dados['sala']))
                array_push($argumentos['mensagens'], 'Sala inválida!');

            # Validação da data
            if (empty($dados['data']) || is_null($dados['data']))
                array_push($argumentos['mensagens'], 'Data inválida!');
            else if (strlen($dados['data']) < 4)
                array_push($argumentos['mensagens'], 'Data deve ter no mínimo 4 caracteres!');

            # Validação do resumo
            if (empty($dados['resumo']) || is_null($dados['resumo']) || is_numeric($dados['resumo']))
                array_push($argumentos['mensagens'], 'Resumo inválido!');
            else if (strlen($dados['resumo']) < 10)
                array_push($argumentos['mensagens'], 'Resumo deve ter no mínimo 10 caracteres!');
            
            # Validação da área
            $areaExiste = $db->count('area', ['id' => $dados['area']]);
            if (empty($dados['area']) || is_null($dados['area']) || !is_numeric($dados['area']) || $areaExiste == 0)
                array_push($argumentos['mensagens'], 'Área inválida!');

            # Validação do tipo
            if (empty($dados['tipo']) || is_null($dados['tipo']) || !in_array($dados['tipo'], [1, 2]))
                array_push($argumentos['mensagens'], 'Tipo inválido!');
            
            # Validação da descrição da mensagem
            if ((empty($dados['imagem_descricao']) || is_null($dados['imagem_descricao'])) && 
                $request->getUploadedFiles()['imagem']->getError() != UPLOAD_ERR_NO_FILE)
                array_push($argumentos['mensagens'], 'Descrição da Imagem Invalida!');

            $tipoNome = $dados['tipo'] == 1 ? 'Mini Curso' : 'Oficina';
            if (count($argumentos['mensagens']) == 0) {
                $cursos_oficinas = new CursoOficina();
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
                    $cursos_oficinas->setImagem_descricao($dados['imagem_descricao']);
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "cursos_oficinas",
                        'imagem',
                        [
                            'id' => $dados['enviar'],
                            "ano_id" => $this->ano_atual['id']
                        ]
                    )[0];
                    if (!empty($cursos_oficinas->getImagem()) || !is_null($cursos_oficinas->getImagem()))
                        $upload->excluir($img, "cursos_oficinas/");
                    $cursos_oficinas->setId($dados['enviar']);
                    $db->update(
                        'cursos_oficinas',
                        $cursos_oficinas->toArray(),
                        [
                            'id' => $cursos_oficinas->getId(),
                            "ano_id" => $this->ano_atual['id']
                        ]
                    );
                    $this->container->flash->addMessage('cursos_oficinas', $tipoNome . ' atualizado com sucesso!');
                } else {
                    $cursos_oficinas->setAno_id($this->ano_atual['id']);
                    $db->insert(
                        'cursos_oficinas',
                        $cursos_oficinas->toArray()
                    );
                    $this->container->flash->addMessage('cursos_oficinas', $tipoNome . ' adicionado com sucesso!');
                }
                return $response->withRedirect($this->container->router->pathFor('cursos_oficinas-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
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
                    'imagem_descricao',
                    'area_id',
                ],
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if($argumentos['curso_oficina'])
                $argumentos['texto'] = 'Atualizar';
            else
                $argumentos['texto'] = 'Adicionar';
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
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if (!empty($img) || !is_null($img)) (new Upload("uploads/"))->excluir($img, "palestras/");
            $db->delete(
                "palestras",
                [
                    "id" => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
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

            # Validação do titulo
            if (empty($dados['titulo']) || is_null($dados['titulo']) || is_numeric($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo inválido!');
            else if (strlen($dados['titulo']) < 5)
                array_push($argumentos['mensagens'], 'Titulo deve ter no mínimo 5 caracteres!');

            # Validação do nome
            if (empty($dados['nome']) || is_null($dados['nome']) || is_numeric($dados['nome']))
                array_push($argumentos['mensagens'], 'Nome inválido!');
            else if (strlen($dados['nome']) < 5)
                array_push($argumentos['mensagens'], 'Nome deve ter no mínimo 5 caracteres!');

            # Validação da sala
            if (empty($dados['sala']) || is_null($dados['sala']))
                array_push($argumentos['mensagens'], 'Sala inválida!');

            # Validação da data
            if (empty($dados['data']) || is_null($dados['data']))
                array_push($argumentos['mensagens'], 'Data inválida!');
            else if (strlen($dados['data']) < 4)
                array_push($argumentos['mensagens'], 'Data deve ter no mínimo 4 caracteres!');

            # Validação do resumo
            if (empty($dados['resumo']) || is_null($dados['resumo']) || is_numeric($dados['resumo']))
                array_push($argumentos['mensagens'], 'Resumo inválido!');
            else if (strlen($dados['resumo']) < 10)
                array_push($argumentos['mensagens'], 'Resumo deve ter no mínimo 10 caracteres!');
            
            # Validação da área
            $areaExiste = $db->count('area', ['id' => $dados['area']]);
            if (empty($dados['area']) || is_null($dados['area']) || !is_numeric($dados['area']) || $areaExiste == 0)
                array_push($argumentos['mensagens'], 'Área inválida!');
            
            # Validação da descrição de imagem
            if ((empty($dados['imagem_descricao']) || is_null($dados['imagem_descricao'])) && 
                $request->getUploadedFiles()['imagem']->getError() != UPLOAD_ERR_NO_FILE)

            if (count($argumentos['mensagens']) == 0) {
                $palestra = new Palestra();
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
                    $palestra->setImagem_descricao($dados['imagem_descricao']);
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "palestras",
                        'imagem',
                        [
                            'id' => $dados['enviar'],
                            "ano_id" => $this->ano_atual['id']
                        ]
                    )[0];
                    if (!empty($palestra->getImagem()) || !is_null($palestra->getImagem()))
                        $upload->excluir($img, "palestras/");
                    $palestra->setId($dados['enviar']);
                    $db->update(
                        'palestras',
                        $palestra->toArray(),
                        [
                            'id' => $palestra->getId(),
                            "ano_id" => $this->ano_atual['id']
                        ]
                    );
                    $this->container->flash->addMessage('palestras', 'Palestra atualizada com sucesso!');
                } else {
                    $palestra->setAno_id($this->ano_atual['id']);
                    $db->insert(
                        'palestras',
                        $palestra->toArray()
                    );

                    $this->container->flash->addMessage('palestras', 'Palestra adicionada com sucesso!');
                }
                return $response->withRedirect($this->container->router->pathFor('palestras-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
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
                    'imagem_descricao',
                    'area_id',
                ],
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if($argumentos['palestra'])
                $argumentos['texto'] = 'Atualizar';
            else
                $argumentos['texto'] = 'Adicionar';
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
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if (!empty($img) || !is_null($img)) (new Upload("uploads/"))->excluir($img, "artistico/");
            $db->delete(
                "artistico",
                [
                    "id" => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
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

            # Validação do titulo
            if (empty($dados['titulo']) || is_null($dados['titulo']) || is_numeric($dados['titulo']))
                array_push($argumentos['mensagens'], 'Titulo inválido!');
            else if (strlen($dados['titulo']) < 5)
                array_push($argumentos['mensagens'], 'Titulo deve ter no mínimo 5 caracteres!');

            # Validação do facilitador
            if (empty($dados['facilitador']) || is_null($dados['facilitador']) || is_numeric($dados['facilitador']))
                array_push($argumentos['mensagens'], 'Facilitador inválido!');
            else if (strlen($dados['facilitador']) < 5)
                array_push($argumentos['mensagens'], 'Facilitador deve ter no mínimo 5 caracteres!');

            # Validação da local
            if (empty($dados['local']) || is_null($dados['local']))
                array_push($argumentos['mensagens'], 'Local inválida!');

            # Validação da data
            if (empty($dados['data']) || is_null($dados['data']))
                array_push($argumentos['mensagens'], 'Data inválida!');
            else if (strlen($dados['data']) < 4)
                array_push($argumentos['mensagens'], 'Data deve ter no mínimo 4 caracteres!');

            # Validação do resumo
            if (empty($dados['resumo']) || is_null($dados['resumo']) || is_numeric($dados['resumo']))
                array_push($argumentos['mensagens'], 'Resumo inválido!');
            else if (strlen($dados['resumo']) < 10)
                array_push($argumentos['mensagens'], 'Resumo deve ter no mínimo 10 caracteres!');
            
            # Validação da área
            $areaExiste = $db->count('area', ['id' => $dados['area']]);
            if (empty($dados['area']) || is_null($dados['area']) || !is_numeric($dados['area']) || $areaExiste == 0)
                array_push($argumentos['mensagens'], 'Área inválida!');

            # Validação do tipo
            if (empty($dados['tipo']) || is_null($dados['tipo']) || !in_array($dados['tipo'], [1, 2, 3, 4]))
                array_push($argumentos['mensagens'], 'Tipo inválido!');
           
            # Validação da descrição de imagem
            if ((empty($dados['imagem_descricao']) || is_null($dados['imagem_descricao'])) && 
                $request->getUploadedFiles()['imagem']->getError() != UPLOAD_ERR_NO_FILE)
                array_push($argumentos['mensagens'], 'Descrição da Imagem Invalida!');

            if (count($argumentos['mensagens']) == 0) {
                $palestra = new Artistico();
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
                    $palestra->setImagem_descricao($dados['imagem_descricao']);
                }
                if (!empty($dados['enviar'])) {
                    $img = $db->select(
                        "artistico",
                        'imagem',
                        [
                            'id' => $dados['enviar'],
                            "ano_id" => $this->ano_atual['id']
                        ]
                    )[0];
                    if (!empty($palestra->getImagem()) || !is_null($palestra->getImagem()))
                        $upload->excluir($img, "artistico/");
                    $palestra->setId($dados['enviar']);
                    $db->update(
                        'artistico',
                        $palestra->toArray(),
                        [
                            'id' => $palestra->getId(),
                            "ano_id" => $this->ano_atual['id']
                        ]
                    );
                    $this->container->flash->addMessage('artistica', 'Mostra artística atualizada com sucesso!');
                } else {
                    $palestra->setAno_id($this->ano_atual['id']);
                    $db->insert(
                        'artistico',
                        $palestra->toArray()
                    );
                    $this->container->flash->addMessage('artistica', 'Mostra artística adicionada com sucesso!');
                }
                return $response->withRedirect($this->container->router->pathFor('artistico-admin'));
            } else {
                $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
            }
        }
        if (isset($args['id'])) {
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
                    'imagem_descricao',
                    'area_id',
                ],
                [
                    'id' => $args['id'],
                    "ano_id" => $this->ano_atual['id']
                ]
            )[0];
            if($argumentos['artistico'])
                $argumentos['texto'] = 'Atualizar';
            else
                $argumentos['texto'] = 'Adicionar';
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

            # Validação do ano
            $anosIguais = $db->count('ano', [
                'nome_ano' => $dados['ano'],
                'id[!]' => $args['id']
            ]);
            if (empty($dados['ano']) || is_null($dados['ano']) || $dados['ano']<2000 || $dados['ano']>2100)
                array_push($argumentos['mensagens'], 'Ano inválido!');
            else if($anosIguais > 0)
                array_push($argumentos['mensagens'], 'Esse ano já foi cadastrado!');
        
            if ((empty($dados['id_evento']) || is_null($dados['id_evento'])) && $dados['id_evento'] <= 0)
                array_push($argumentos['mensagens'], 'Id do Evento inválido!');


            if (count($argumentos['mensagens']) == 0) {
                $ano = new Ano();
                $ano->setNome_ano($dados['ano']);
                $ano->setIdEvento($dados['id_evento']);
                $ano->setStatus($dados['status']);
                $ano->setEditais($dados['editais']);
                $ano->setCronogramas($dados['cronogramas']);
                $ano->setNoticias($dados['noticias']);
                $ano->setPalestras($dados['palestras']);
                $ano->setApresentacoes($dados['apresentacoes']);
                if ($ano->getStatus() == 1) {
                    $db->update(
                        'ano',
                        [
                            'status' => 0
                        ]
                    );
                }
                if (!empty($dados['enviar'])) {
                    $ano->setId($dados['enviar']);
                    $db->update(
                        'ano',
                        $ano->toArray(),
                        [
                            'id' => $ano->getId()
                        ]
                    );
                    $this->container->flash->addMessage('anos', 'Ano atualizado com sucesso!');
                } else {
                    $db->insert(
                        'ano',
                        $ano->toArray()
                    );
                    $this->container->flash->addMessage('anos', 'Ano adicionado com sucesso!');
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
                    'id_evento',
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
                array_push($argumentos['mensagens'], 'Nome inválido!');
            if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL))
                array_push($argumentos['mensagens'], 'Email inválido!');
            if (($dados['new-pass'] != $dados['confirm-pass'] ||
                 $dados['pass'] == $dados['new-pass'] || 
                 empty($dados['new-pass']) || is_null($dados['new-pass']) ||
                 empty($dados['pass']) || is_null($dados['pass'])))
                array_push($argumentos['mensagens'], 'Senha inválida!');
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
