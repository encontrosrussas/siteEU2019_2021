<?php

namespace app\models;

class Apresentacao{
    private $id;
    private $nome;
    private $resumo;
    private $autor;
    private $trilha;
    private $id_fake;
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
     * Get the value of id_fake
     */ 
    public function getIdFake()
    {
        return $this->id_fake;
    }

    /**
     * Set the value of id_fake
     */ 
    public function setIdFake($id_fake)
    {
        if (!empty($id_fake) && !is_null($id_fake))
            $this->id_fake = $id_fake;
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
     * Get the value of autor
     */ 
    public function getAutor()
    {
        return $this->autor;
    }

    /**
     * Set the value of autor
     */ 
    public function setAutor($autor)
    {
        if (!empty($autor) && !is_null($autor))
            $this->autor = $autor;
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
    public function getTrilha()
    {
        return $this->trilha;
    }

    /**
     * Set the value of area
     */ 
    public function setTrilha($trilha)
    {
        if (!empty($trilha) && !is_null($trilha))
            $this->trilha = $trilha;
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

    public function toArray($fake=false)
    {
        $retorno = [];
        if (!is_null($this->getNome()))
            $retorno["nome"] = $this->getNome();
        if (!is_null($this->getResumo()))
            $retorno["resumo"] = $this->getResumo();
        if (!is_null($this->getTrilha()))
            $retorno["trilha"] = $this->getTrilha();
        if (!is_null($this->getAutor()))
            $retorno["autor"] = $this->getAutor();
        if ($fake && !is_null($this->getIdFake()))
            $retorno["id_fake"] = $this->getIdFake();
        if (!is_null($this->getAno_id()))
            $retorno["ano_id"] = $this->getAno_id();
        return $retorno;
    }
}