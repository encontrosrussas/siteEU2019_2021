<?php

namespace app\models;

use app\helpers\Ilogin;

class Usuario implements Ilogin{
    private $id;   
    private $nome;   
    private $email;   
    private $senha;   
    private $tipo;   

    public function __construct($id=null, $nome=null, $email=null, $senha=null, $tipo=null)
    {
        $this->setId($id);
        $this->setNome($nome);
        $this->setEmail($email);
        $this->setSenha($senha);
        $this->setTipo($tipo);
    }

    public function logar($db, $email, $password){
        $user = $db->select(
            "usuarios",
            [
                'id',
                'nome',
                'email',
                'senha',
                'tipo',
            ],
            [
                'email' => $email,
                'senha' => $password,
            ]
        );
        return (count($user) == 1) ? $user[0] : false;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     */ 
    public function setId($id)
    {
        if (!empty($id) && !is_null($id))
            $this->id = $id;
    }

    /**
     * Get the value of nome
     */ 
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set the value of nome
     */ 
    public function setNome($nome)
    {
        if (!empty($nome) && !is_null($nome))
            $this->nome = $nome;
    }

    /**
     * Get the value of email
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     */ 
    public function setEmail($email)
    {
        if (!empty($email) && !is_null($email))
            $this->email = $email;
    }

    /**
     * Get the value of senha
     */ 
    public function getSenha()
    {
        return $this->senha;
    }

    /**
     * Set the value of senha
     */ 
    public function setSenha($senha)
    {
        if (!empty($senha) && !is_null($senha))
            $this->senha = $senha;
    }

    /**
     * Get the value of tipo
     * 
     */ 
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * Set the value of tipo
     */ 
    public function setTipo($tipo)
    {   
        if(!empty($tipo) && !is_null($tipo))
            $this->tipo = $tipo;
    }

    public function cripografarSenha(){
        if(!empty($this->senha) && !is_null($this->senha))
            $this->senha = hash('sha512', $this->senha);
    }

    public function verificarSenha($senhaComparar){
        if(!empty($senhaComparar) && !is_null($senhaComparar))
            return $this->senha == hash('sha512', $senhaComparar);
        else
            throw new \Exception("Senha Vazia.");
    }

    public function toArray()
    {
        $retorno =[];
        if(!is_null($this->getNome()))
            $retorno["nome"] = $this->getNome();
        if(!is_null($this->getEmail()))
            $retorno["email"] = $this->getEmail();
        if(!is_null($this->getSenha()))
            $retorno["senha"] = $this->getSenha();
        if(!is_null($this->getTipo()))
            $retorno["tipo"] = $this->getTipo();
        return $retorno;
    }
}