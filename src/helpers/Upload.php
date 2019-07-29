<?php

namespace app\helpers;

/**
 * Class Upload
 * @package app\helpers
 */
class Upload
{
    /**
     * Pega o Array do Arquivo
     * @var
     */
    private $arquivo;
    /**
     * Retorna o Resultado do Upload
     * @var
     */
    private $result;
    /**
     * Retorna o nome do arquivo
     * @var
     */
    private $name;
    /**
     * Retorna uma Mensagem sobre o Upload
     * @var
     */
    private $msg;
    /**
     * Cria uma copia da imagem enviada
     * @var
     */
    private $imagem;
    /**
     * Recebe o Caminho Raiz para criação da Pasta
     * @var string
     */
    private $pathRoot;
    /**
     * Recebe o Diretorio atual
     * @var string
     */
    private static $diretorio;
    /**
     * Upload constructor.
     * @param null $diretorio
     */
    public function __construct($diretorio = null)
    {
        self::$diretorio = ((string) $diretorio ? $diretorio : "arquivos/");
        // $root = $_SERVER['DOCUMENT_ROOT'];
        // $path = $_SERVER['REQUEST_URI'];
        // $path = ltrim($path, '/');
        // $path = explode('/', $path);
        // $cam = $path[0] . "/";
        // $path = $cam;
        $this->pathRoot = self::$diretorio;
        self::$diretorio = $this->pathRoot;
        if (!file_exists(self::$diretorio) && !is_dir(self::$diretorio)) :
            mkdir(self::$diretorio);
        endif;
    }
    /**
     * Pega o Resultado
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
    /**
     * Pega a Mensagem
     * @return mixed
     */
    public function getMsg()
    {
        return $this->msg;
    }
    /**
     * Pega o nome do arquivo
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     * Faz Upload Multiplo de Imagens
     * @param array $upload
     * @param null $name
     * @param null $folder
     */
    public function image($upload, $name = null, $folder = null)
    {
        $folder = ((string) $folder);
        $folders = explode('/', $folder);
        for ($i = 0; $i < count($folders); $i++) :
            if (!empty($folders[$i])) :
                self::$diretorio .= $folders[$i] . "/";
                if (!file_exists(self::$diretorio) && !is_dir(self::$diretorio)) :
                    mkdir(self::$diretorio);
                endif;
            endif;
        endfor;
        if (is_array($upload["name"])) :
            $data = null;
            foreach ($upload['error'] as $campo => $valor) {
                foreach ($upload as $key => $value) {
                    $data[$key] = $upload[$key][$campo];
                }
                $ext = explode('.', $data['name']);
                $ext = "." . $ext[count($ext) - 1];
                $data["name"] = $name[$campo] ? $name[$campo] . $ext : $data["name"];
                $this->arquivo = $data;
                $this->uploadImagem();
            } 
        else :
            if (is_array($name)) :
                $this->arquivo = $upload;
                $this->uploadImagem();
            else :
                $ext = explode('.', $upload['name']);
                $ext = "." . $ext[count($ext) - 1];
                $upload["name"] = $name ? $name . $ext : $upload["name"];
                $this->arquivo = $upload;
                $this->uploadImagem();
            endif;
        endif;
    }
    /**
     * Verifica se o arquivo é uma imagem
     */
    private function uploadImagem()
    {
        $file_dimensions = getimagesize($this->arquivo['tmp_name']);
        $file_type = strtolower($file_dimensions['mime']);
        switch ($file_type):
            case 'image/jpeg':
            case 'image/pjpeg':
                $this->imagem = imagecreatefromjpeg($this->arquivo["tmp_name"]);
                break;
            case 'image/png':
            case 'image/x-png':
                $this->imagem = imagecreatefrompng($this->arquivo["tmp_name"]);
                break;
        endswitch;
        if (!$this->imagem) :
            $this->result = false;
            $this->msg = "tipo de Arquivo invalido, envie imagems JPG ou PNG";
        else :
            $this->moveArquivo($this->arquivo);
            imagedestroy($this->imagem);
        endif;
    }
    /**
     * Faz Upload Multiplo de Arquivos
     * @param $file
     * @param null $name
     * @param null $folder
     * @param null $maxFileSize
     * @param bool $verificacao
     */
    public function file($file, $name = null, $folder = null, $maxFileSize = null, $verificacao = true)
    {
        $folder = ((string) $folder);
        $folders = explode('/', $folder);
        for ($i = 0; $i < count($folders); $i++) :
            if (!empty($folders[$i])) :
                self::$diretorio .= $folders[$i] . "/";
                if (!file_exists(self::$diretorio) && !is_dir(self::$diretorio)) :
                    mkdir(self::$diretorio);
                endif;
            endif;
        endfor;
        if (is_array($file["name"])) :
            $data = null;
            foreach ($file['error'] as $campo => $valor) {
                foreach ($file as $key => $value) {
                    $data[$key] = $file[$key][$campo];
                }
                $ext = explode('.', $data['name']);
                $ext = "." . $ext[count($ext) - 1];
                $data["name"] = $name[$campo] ? $name[$campo] . $ext : $data["name"];
                $this->arquivo = $data;
                $this->verificaEnviaArquivos($maxFileSize, $verificacao);
            } 
        else :
            if (is_array($name)) :
                $this->arquivo = $file;
                $this->verificaEnviaArquivos($maxFileSize, $verificacao);
            else :
                $ext = explode('.', $file['name']);
                $ext = "." . $ext[count($ext) - 1];
                $file["name"] = $name ? $name . $ext : $file["name"];
                $this->arquivo = $file;
                $this->verificaEnviaArquivos($maxFileSize, $verificacao);
            endif;
        endif;
    }
    /**
     * Verifica o Tipo do arquivo e o tamanho maximo
     * @param null $maxFileSize
     * @param bool $verificacao
     */
    private function verificaEnviaArquivos($maxFileSize = null, $verificacao = true)
    {
        if ($verificacao) :
            $fileAccept = [
                "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
                "application/save",
                "application/pdf"
            ];
        else :
            $fileAccept = [
                $this->arquivo['type']
            ];
        endif;
        if (is_null($maxFileSize)) :
            $maxFileSize = 1024 * 1024;
        else :
            $maxFileSize = $maxFileSize * (1024 * 1024);
        endif;
        if ($this->arquivo['size'] > $maxFileSize) :
            $this->result = false;
            $this->msg = "Arquivo muito grande, tamanho maximo permitido {$maxFileSize}mb";
        elseif (!in_array($this->arquivo['type'], $fileAccept)) :
            $this->result = false;
            $this->msg = "Tipo de Arquivo não suportado. envie .PDF ou .DOCX";
        else :
            $this->moveArquivo($this->arquivo);
        endif;
    }
    /**
     * Excluir Imagem/Arquivo da pasta
     * @param $nome
     * @param null $pasta
     */
    public function excluir($nome, $pasta = null)
    {
        if (!is_null($pasta)) :
            $pasta = trim($pasta, '/') . '/';
        endif;
        if (file_exists(self::$diretorio . $pasta . $nome)) :
            if (unlink(self::$diretorio . $pasta . $nome)) :
                $this->msg = "Arquivo $nome exluido com sucesso!";
            else :
                $this->msg = "Erro ao excluir Arquivo $nome!";
            endif;
        else :
            $this->msg = "Arquivo $nome não encontrado!";
        endif;
    }
    /**
     * Move o arquivo para o caminho da Variavel Diretorio
     * @param array $upload
     */
    private function moveArquivo($upload)
    {
        if (move_uploaded_file($upload["tmp_name"], self::$diretorio . $upload["name"])) :
            $this->result = true;
            $this->name = $upload["name"];
            $this->msg = "upload realizado com sucesso";
        else :
            $this->result = false;
            $this->name = $this->pathRoot . 'imagem_nao_cadastrada.png';
            $this->msg = "upload não foi realizado com sucesso";
        endif;
        self::$diretorio = $this->pathRoot;
    }
}
