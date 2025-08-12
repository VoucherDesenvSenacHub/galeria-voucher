<?php

require_once __DIR__ . "/../Model/ImagensModel.php";

class ImagesUploadService
{
    private $imagem;
    private $diretorioDestino = "uploads/";
    private $mimeTypesPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    private $extensoesPermitidas = ['jpg', 'png', 'gif'];
    private $tamanhoMaximo = 16 * 1024 * 1024; // 16mb

    public function __construct($imagem)
    {
        $this->imagem = $imagem;
        $this->validarImagem();
    }

    private function validarImagem()
    {
        if (!in_array($this->imagem['type'], $this->mimeTypesPermitidos)) {
            throw new \Exception("Tipo de arquivo não permitido.");
        }

        $extensaoImagem = strtolower(pathinfo(
            $this->imagem['name'],
            PATHINFO_EXTENSION
        ));

        if (!in_array($extensaoImagem, $this->extensoesPermitidas)) {
            throw new \Exception("Extensão de arquivo não permitida.");
        }

        if ($this->imagem['size'] > $this->tamanhoMaximo) {
            throw new \Exception("Tamanho da imagem muito grande.");
        }
    }

    public function upload()
    {
        if (!is_dir($this->diretorioDestino)) {
            mkdir($this->diretorioDestino, 0777, true);
        }

        $nomeUnico = uniqid() . "_" . $this->imagem['name'];
        $caminhoDaImagem = $this->diretorioDestino . $nomeUnico;

        $salvou = move_uploaded_file(
            $this->imagem['tmp_name'],
            $caminhoDaImagem
        );

        if (!$salvou) {
            throw new \Exception("Erro ao salvar a imagem.");
        }

        $imagensModel = new ImagensModel();
        $imagensModel->salvar([
            'nome' => $nomeUnico,
            'nome_original' => $this->imagem['name'],
            'caminho' => $caminhoDaImagem
        ]);

        return true;

        // return [
        //     'salvou' => true,
        //     'id' => $imagemSalva['id'],
        //     'caminho' => $caminhoDaImagem,
        //     'nome_original' => $this->imagem['name']
        // ];
    }
}