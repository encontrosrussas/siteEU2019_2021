<?php

namespace app\controllers;

use app\models\Usuario;
use PDOException;

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
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/login.html');
    }

    public function dashboard($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/index.html');
    }

    public function usuarios($request, $response, $args)
    {
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
    
    public function usuarios_modificar($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        $db = $this->container->db;
        $argumentos = [];
        if (!is_null($request->getParsedBody())) {
            $argumentos['mensagens'] = [];
            $dados = $request->getParsedBody();
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

    public function noticias($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/noticias.html');
    }
    
    public function areas($request, $response, $args)
    {
        $areas = $this->container->db->select("area",[
            'id', 'nome', 'descricao'
        ]);
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/areas.html',[
            'areas'=>$areas
        ]);
    }

    public function editais($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/editais.html');
    }

    public function paginas($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/paginas.html');
    }

    public function cronogramas($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/cronogramas.html');
    }

    public function apresentacoes($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/apresentacoes.html');
    }

    public function mini_cursos($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/mini_cursos.html');
    }

    public function palestras($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/palestras.html');
    }
    
    public function anos($request, $response, $args)
    {
        $anos = $this->container->db->select(
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

    public function conta($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/conta.html');
    }

    public function sair($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $response->withStatus(200)->withHeader('Location', $this->container->router->urlFor("login-admin"));
    }

    public function template($request, $response, $args)
    {
        $this->container->get('logger')->info("'{$_SERVER['REQUEST_URI']}' route");
        return $this->container->view->render($response, 'admin/template/'.$args['nome']);
    }
}
