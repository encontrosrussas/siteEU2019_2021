<?php

namespace app\models;

class Edital{
    private $id;
    private $nome;
    private $descricao;
    private $tipo;
    private $arquivo;
    private $ano_id;

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

    /**
     * Get the value of tipo
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
        if (!empty($tipo) && !is_null($tipo))
        $this->tipo = $tipo;
    }

    /**
     * Get the value of ano_id
     */ 
    public function getAno_id()
    {
        return $this->ano_id;
    }

    /**
     * Set the value of ano_id
     */ 
    public function setAno_id($ano_id)
    {
        if (!empty($ano_id) && !is_null($ano_id))
        $this->ano_id = $ano_id;
    }

    /**
     * Get the value of arquivo
     */
    public function getArquivo()
    {
        return $this->arquivo;
    }

    /**
     * Set the value of arquivo
     */
    public function setArquivo($arquivo)
    {
        if (!empty($arquivo) && !is_null($arquivo))
        $this->arquivo = $arquivo;
    }

    public function toArray()
    {
        $retorno = [];
        if (!is_null($this->getNome()))
            $retorno["nome"] = $this->getNome();
        if (!is_null($this->getDescricao()))
            $retorno["descricao"] = $this->getDescricao();
        if (!is_null($this->getArquivo()))
            $retorno["arquivo"] = $this->getArquivo();
        if (!is_null($this->getTipo()))
            $retorno["tipo"] = $this->getTipo();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}