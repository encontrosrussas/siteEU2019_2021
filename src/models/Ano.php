<?php

namespace app\models;

class Ano
{
    private $id;
    private $nome_ano;
    private $id_evento;
    private $status;
    private $editais;
    private $cronogramas;
    private $noticias;
    private $palestras;
    private $apresentacoes;

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
     * Get the value of nome_ano
     */
    public function getNome_ano()
    {
        return $this->nome_ano;
    }

    /**
     * Set the value of nome_ano
     */
    public function setNome_ano($nome_ano)
    {
        if (!empty($nome_ano) && !is_null($nome_ano))
            $this->nome_ano = $nome_ano;
    }

    /**
     * Get the value of id_evento
     */
    public function getIdEvento()
    {
        return $this->id_evento;
    }

    /**
     * Set the value of id_evento
     */
    public function setIdEvento($id_evento)
    {
        if (!empty($id_evento) && !is_null($id_evento))
            $this->id_evento = $id_evento;
    }

    /**
     * Get the value of status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     */
    public function setStatus($status)
    {
        if (!is_null($status))
        $this->status = $status;
    }

    /**
     * Get the value of editais
     */
    public function getEditais()
    {
        return $this->editais;
    }

    /**
     * Set the value of editais
     */
    public function setEditais($editais)
    {
        if (!is_null($editais))
            $this->editais = $editais;
    }

    /**
     * Get the value of cronogramas
     */
    public function getCronogramas()
    {
        return $this->cronogramas;
    }

    /**
     * Set the value of cronogramas
     */
    public function setCronogramas($cronogramas)
    {
        if (!is_null($cronogramas))
            $this->cronogramas = $cronogramas;
    }

    /**
     * Get the value of noticias
     */ 
    public function getNoticias()
    {
        return $this->noticias;
    }

    /**
     * Set the value of noticias
     */ 
    public function setNoticias($noticias)
    {
        if (!is_null($noticias))
            $this->noticias = $noticias;
    }

    /**
     * Get the value of palestras
     */ 
    public function getPalestras()
    {
        return $this->palestras;
    }

    /**
     * Set the value of palestras
     */ 
    public function setPalestras($palestras)
    {
        if (!is_null($palestras))
        $this->palestras = $palestras;
    }

    /**
     * Get the value of apresentacoes
     */ 
    public function getApresentacoes()
    {
        return $this->apresentacoes;
    }

    /**
     * Set the value of apresentacoes
     */ 
    public function setApresentacoes($apresentacoes)
    {
        if (!is_null($apresentacoes))
            $this->apresentacoes = $apresentacoes;
    }
    
    public function toArray()
    {
        $retorno = [];
        if (!is_null($this->getNome_ano()))
            $retorno["nome_ano"] = $this->getNome_ano();
        if (!is_null($this->getIdEvento()))
            $retorno["id_evento"] = $this->getIdEvento();
        if (!is_null($this->getStatus()))
            $retorno["status"] = $this->getStatus();
        if (!is_null($this->getEditais()))
            $retorno["editais"] = $this->getEditais();
        if (!is_null($this->getCronogramas()))
            $retorno["cronogramas"] = $this->getCronogramas();
        if (!is_null($this->getNoticias()))
            $retorno["noticias"] = $this->getNoticias();
        if (!is_null($this->getPalestras()))
            $retorno["palestras"] = $this->getPalestras();
        if (!is_null($this->getApresentacoes()))
            $retorno["apresentacoes"] = $this->getApresentacoes();
        return $retorno;
    }
}
