<?php

namespace app\models;

class Artistico{
    private $id;
    private $titulo;
    private $facilitador;
    private $data;
    private $resumo;
    private $local;
    private $imagem;
    private $imagem_descricao;
    private $tipo;
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
     * Get the value of facilitador
     */ 
    public function getFacilitador()
    {
        return $this->facilitador;
    }

    /**
     * Set the value of facilitador
     */ 
    public function setFacilitador($facilitador)
    {
        if (!empty($facilitador) && !is_null($facilitador))
        $this->facilitador = $facilitador;
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
     * Get the value of imagem_descricao
     */
    public function getImagem_descricao()
    {
        return $this->imagem_descricao;
    }

    /**
     * Set the value of imagem_descricao
     */
    public function setImagem_descricao($imagem_descricao)
    {
        if (!empty($imagem_descricao) && !is_null($imagem_descricao))
            $this->imagem_descricao = $imagem_descricao;
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
        if (!empty($tipo) && !is_null($tipo))
            $this->tipo = $tipo;
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
     * Get the value of local
     */
    public function getLocal()
    {
        return $this->local;
    }

    /**
     * Set the value of local
     */
    public function setLocal($local)
    {
        if (!empty($local) && !is_null($local))
            $this->local = $local;
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
        if (!is_null($this->getTitulo()))
            $retorno["titulo"] = $this->getTitulo();
        if (!is_null($this->getFacilitador()))
            $retorno["facilitador"] = $this->getFacilitador();
        if (!is_null($this->getData()))
            $retorno["data"] = $this->getData();
        if (!is_null($this->getResumo()))
            $retorno["resumo"] = $this->getResumo();
        if (!is_null($this->getLocal()))
            $retorno["local"] = $this->getLocal();
        if (!is_null($this->getImagem()))
            $retorno["imagem"] = $this->getImagem();
        if (!is_null($this->getImagem_descricao()))
            $retorno["imagem_descricao"] = $this->getImagem_descricao();
        if (!is_null($this->getTipo()))
            $retorno["tipo"] = $this->getTipo();
        if (!is_null($this->getArea_id()))
            $retorno["area_id"] = $this->getArea_id();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}