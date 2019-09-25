<?php

namespace app\models;

class CursoOficina{
    private $id;
    private $titulo;
    private $nome;
    private $data;
    private $resumo;
    private $sala;
    private $imagem;
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
     * Get the value of sala
     */
    public function getSala()
    {
        return $this->sala;
    }

    /**
     * Set the value of sala
     */
    public function setSala($sala)
    {
        if (!empty($sala) && !is_null($sala))
            $this->sala = $sala;
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
        if (!is_null($this->getNome()))
            $retorno["nome"] = $this->getNome();
        if (!is_null($this->getData()))
            $retorno["data"] = $this->getData();
        if (!is_null($this->getResumo()))
            $retorno["resumo"] = $this->getResumo();
        if (!is_null($this->getSala()))
            $retorno["sala"] = $this->getSala();
        if (!is_null($this->getImagem()))
            $retorno["imagem"] = $this->getImagem();
        if (!is_null($this->getTipo()))
            $retorno["tipo"] = $this->getTipo();
        if (!is_null($this->getArea_id()))
            $retorno["area_id"] = $this->getArea_id();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}