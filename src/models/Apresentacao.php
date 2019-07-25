<?php

namespace app\models;

class Apresentacao{
    private $id;
    private $nome;
    private $data;
    private $hora;
    private $area;
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
     * Get the value of area
     */ 
    public function getArea()
    {
        return $this->area;
    }

    /**
     * Set the value of area
     */ 
    public function setArea($area)
    {
        if (!empty($area) && !is_null($area))
            $this->area = $area;
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
            "data" => $this->data,
            "hora" => $this->hora,
            "area" => $this->area,
            "ano_id" => $this->ano_id
        ];
    }
}