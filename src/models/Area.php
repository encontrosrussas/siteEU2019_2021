<?php

namespace app\models;

class Area{
    private $id;
    private $nome;
    private $descricao;
    
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
     * Get the value of descricao
     */ 
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * Set the value of descricao
     */
    public function setDescricao($descricao)
    {
        if (!empty($descricao) && !is_null($descricao))
        $this->descricao = $descricao;
    }

    public function toArray()
    {
        $retorno = [];
        if (!is_null($this->getNome()))
            $retorno["nome"] = $this->getNome();
        if (!is_null($this->getDescricao()))
            $retorno["descricao"] = $this->getDescricao();
        return $retorno;
    }
}