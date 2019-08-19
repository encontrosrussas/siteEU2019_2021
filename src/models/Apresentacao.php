<?php

namespace app\models;

class Apresentacao{
    private $id;
    private $nome;
    private $resumo;
    private $area_id;
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
     * Get the value of resumo
     */ 
    public function getResumo()
    {
        return $this->resumo;
    }

    /**
     * Set the value of resumo
     */ 
    public function setResumo($resumo)
    {
        if (!empty($resumo) && !is_null($resumo))
            $this->resumo = $resumo;
    }

    /**
     * Get the value of area
     */ 
    public function getArea_id()
    {
        return $this->area_id;
    }

    /**
     * Set the value of area
     */ 
    public function setArea_id($area_id)
    {
        if (!empty($area_id) && !is_null($area_id))
            $this->area_id = $area_id;
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
        $retorno = [];
        if (!is_null($this->getNome()))
            $retorno["nome"] = $this->getNome();
        if (!is_null($this->getResumo()))
            $retorno["resumo"] = $this->getResumo();
        if (!is_null($this->getArea_id()))
            $retorno["area_id"] = $this->getArea_id();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}