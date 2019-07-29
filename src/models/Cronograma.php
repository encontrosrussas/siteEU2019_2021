<?php

namespace app\models;

class Cronograma{
    private $id;
    private $dia;
    private $imagem;
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
     * Get the value of dia
     */ 
    public function getDia()
    {
        return $this->dia;
    }

    /**
     * Set the value of dia
     */ 
    public function setDia($dia)
    {
        if (!empty($dia) && !is_null($dia))
            $this->dia = $dia;
    }

    /**
     * Get the value of imagem
     */ 
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set the value of imagem
     */ 
    public function setImagem($imagem)
    {
        if (!empty($imagem) && !is_null($imagem))
            $this->imagem = $imagem;
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
        if (!is_null($this->getDia()))
            $retorno["dia"] = $this->getDia();
        if (!is_null($this->getImagem()))
            $retorno["imagem"] = $this->getImagem();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}