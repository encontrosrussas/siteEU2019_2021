<?php

namespace app\models;

class Palestra{
    private $id;
    private $nome;
    private $data;
    private $hora;
    private $imagem;
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
     * Get the value of data
     */ 
    public function getData()
    {
        return $this->data;
    }

    /**
     * Set the value of data
     */ 
    public function setData($data)
    {
        if (!empty($data) && !is_null($data))
        $this->data = $data;
    }

    /**
     * Get the value of hora
     */ 
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set the value of hora
     */ 
    public function setHora($hora)
    {
        if (!empty($hora) && !is_null($hora))
        $this->hora = $hora;
    }
    
    /**
     * Get the value of hora
     */ 
    public function getImagem()
    {
        return $this->imagem;
    }

    /**
     * Set the value of hora
     */ 
    public function setImagem($imagem)
    {
        if (!empty($imagem) && !is_null($imagem))
        $this->imagem = $imagem;
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
        if (!is_null($this->getData()))
            $retorno["data"] = $this->getData();
        if (!is_null($this->getHora()))
            $retorno["hora"] = $this->getHora();
        if (!is_null($this->getImagem()))
            $retorno["imagem"] = $this->getImagem();
        if (!is_null($this->getArea_id()))
            $retorno["area_id"] = $this->getArea_id();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}