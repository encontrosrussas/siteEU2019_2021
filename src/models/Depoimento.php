<?php

namespace app\models;

class Depoimento{
    private $id;
    private $nome_autor;
    private $depoimento;
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
     * Get the value of nome_autor
     */ 
    public function getNomeAutor()
    {
        return $this->nome_autor;
    }

    /**
     * Set the value of nome_autor
     */ 
    public function setNomeAutor($nome_autor)
    {
        if (!empty($nome_autor) && !is_null($nome_autor))
        $this->nome_autor = $nome_autor;
    }

    /**
     * Get the value of depoimento
     */ 
    public function getDepoimento()
    {
        return $this->depoimento;
    }

    /**
     * Set the value of depoimento
     */
    public function setDepoimento($depoimento)
    {
        if (!empty($depoimento) && !is_null($depoimento))
        $this->depoimento = $depoimento;
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
        if (!is_null($this->getNomeAutor()))
            $retorno["nome_autor"] = $this->getNomeAutor();
        if (!is_null($this->getDepoimento()))
            $retorno["depoimento"] = $this->getDepoimento();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}