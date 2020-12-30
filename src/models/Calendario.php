<?php

namespace app\models;

class Calendario{
    private $id;
    private $data;
    private $descricao;
    private $link;
    private $icone;
    private $concluido;
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
     * Get the value of link
     */ 
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Set the value of link
     */
    public function setLink($link)
    {
        if (!empty($link) && !is_null($link))
        $this->link = $link;
    }

    /**
     * Get the value of icone
     */ 
    public function getIcone()
    {
        return $this->icone;
    }

    /**
     * Set the value of icone
     */
    public function setIcone($icone)
    {
        if (!empty($icone) && !is_null($icone))
        $this->icone = $icone;
    }

    /**
     * Get the value of concluido
     */ 
    public function getConcluido()
    {
        return $this->concluido;
    }

    /**
     * Set the value of concluido
     */
    public function setConcluido($concluido)
    {
        if (!empty($concluido) && !is_null($concluido))
        $this->concluido = $concluido;
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
        if (!is_null($this->getData()))
            $retorno["data"] = $this->getData();
        if (!is_null($this->getDescricao()))
            $retorno["descricao"] = $this->getDescricao();
        if (!is_null($this->getLink()))
            $retorno["link"] = $this->getLink();
        if (!is_null($this->getIcone()))
            $retorno["icone"] = $this->getIcone();
        if (!is_null($this->getConcluido()))
            $retorno["concluido"] = $this->getConcluido();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}