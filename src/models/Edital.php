<?php

namespace app\models;

class Edital{
    private $id;
    private $nome;
    private $descricao;
    private $tipo;
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

    public function toArray()
    {
        return [
            "nome" => $this->nome,
            "descricao" => $this->descricao,
            "tipo" => $this->tipo,
            "ano_id" => $this->ano_id
        ];
    }
}