<?php

namespace app\models;

class Noticia{
    private $id;
    private $titulo;
    private $data;
    private $hora;
    private $imagem;
    private $conteudo;
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
     * Get the value of titulo
     */ 
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set the value of titulo
     */ 
    public function setTitulo($titulo)
    {
        if (!empty($titulo) && !is_null($titulo))
        $this->titulo = $titulo;
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
     * Get the value of conteudo
     */ 
    public function getConteudo()
    {
        return $this->conteudo;
    }

    /**
     * Set the value of conteudo
     */ 
    public function setConteudo($conteudo)
    {
        if (!empty($conteudo) && !is_null($conteudo))
        $this->conteudo = $conteudo;
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
        if (!is_null($this->getTitulo()))
            $retorno["titulo"] = $this->getTitulo();
        if (!is_null($this->getData()))
            $retorno["data"] = $this->getData();
        if (!is_null($this->getHora()))
            $retorno["hora"] = $this->getHora();
        if (!is_null($this->getImagem()))
            $retorno["imagem"] = $this->getImagem();
        if (!is_null($this->getConteudo()))
            $retorno["conteudo"] = $this->getConteudo();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}