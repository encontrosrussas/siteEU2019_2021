<?php

namespace app\helpers;

use app\helpers\Ilogin;

/**
 * Class Login
 * @package App\Classes
 */
class Login
{
    /**
     * Recebe os Dados do Usuario do Banco de Dados
     * @var
     */
    private $dadosUsuario;
    /**
     * Recebe a conexão com o Banco de Dados
     * @var
     */
    private $db;
    /**
     * Recebe a Instancia da Classe Password
     * @var Password
     */
    private $classePassword;
    /**
     * Recebe o Email do Usuario
     * @var
     */
    private $email;
    /**
     * Recebe o Password do Usuario
     * @var
     */
    private $password;
    /**
     * Recebe a Instancia da Classe Ilogin
     * @var Ilogin
     */
    private $usuario;
    /**
     * Login constructor.
     * @param Ilogin $login
     */
    public function __construct($login, $db)
    {
        $this->classePassword = new Password();
        $this->db = $db;
        if (method_exists($login, 'logar')) :
            $this->usuario = $login;
        endif;
    }
    /**
     * Metodo setter Email
     * @param $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }
    /**
     * Metodo setter Password
     * @param $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Verifica se a senha esta correta
     * @param bool $criptografia
     * @return bool
     */
    private function verificarPassword()
    {
        $this->dadosUsuario = $this->db->select(
            "usuarios",
            [
                'id',
                'nome',
                'email',
                'senha',
                'tipo',
            ],
            [
                'email' => $this->email
            ]
        )[0];
        return $this->classePassword->verificarPassword($this->password, $this->dadosUsuario['senha']);
    }

    /**
     * Loga o usuario No sistema
     * @param bool $criptografia
     * @return bool
     */
    public function logar()
    {
        if ($this->verificarPassword()) :
            $logado = $this->usuario->logar($this->db, $this->email, $this->dadosUsuario['senha']);
            if ($logado) :
                $_SESSION['logado'] = true;
                $_SESSION['id'] = $this->dadosUsuario['id'];
                $_SESSION['nome'] = $this->dadosUsuario['nome'];
                $_SESSION['email'] = $this->dadosUsuario['email'];
                $_SESSION['tipo'] = $this->dadosUsuario['tipo'];
                session_regenerate_id();
                return true;
            endif;
        else :
            return false;
        endif;
    }

    public static function checkLogin()
    {
        return isset($_SESSION['logado']) || $_SESSION['logado'] || (int) $_SESSION["id"] > 0;
    }

    public static function verifyLogin($rota)
    {
        if (!Login::checkLogin()) {
            header("Location: " . $rota);
            exit;
        }
    }
    
    public static function redirectLogin($rota)
    {  
        if (Login::checkLogin()) {
            header("Location: " . $rota);
            exit;
        }
    }
    
    public static function logout()
    {
        session_destroy();
    }
}
