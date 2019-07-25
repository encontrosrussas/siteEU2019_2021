<?php

namespace app\models;

class Usuario{
    private $id;   
    private $nome;   
    private $email;   
    private $senha;   
    private $tipo;   

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
            $this->senha = md5($this->senha);
    }

    public function verificarSenha($senhaComparar){
        if(!empty($senhaComparar) && !is_null($senhaComparar))
            return $this->senha == md5($senhaComparar);
        else
            throw new Exception("Senha Vazia.");
    }

    public function toArray()
    {
        return [
            "nome" => $this->nome,
            "email" => $this->email,
            "senha" => $this->senha,
            "tipo" => $this->tipo
        ];
    }
}