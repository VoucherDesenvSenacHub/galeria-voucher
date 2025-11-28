<?php

require_once __DIR__ . '/../Model/ImagemModel.php';

class ImagensUploadService
{
    private $diretorioUpload;
    private ImagemModel $model;

    public function __construct()
    {
        // Define o diretório de uploads na raiz do projeto
        $this->diretorioUpload = __DIR__ . '/../../Uploads/';
        if (!is_dir($this->diretorioUpload)) {
            mkdir($this->diretorioUpload, 0777, true);
        }

        $this->model = new ImagemModel();
    }

    /**
     * Processa o upload de um arquivo de imagem.
     *
     * @param array $arquivo O arquivo vindo de $_FILES.
     * @param string $prefixo O prefixo para o nome do arquivo.
     * @return array Retorna um array com 'success' => true e 'caminho' em caso de sucesso,
     * ou 'success' => false e 'erro' em caso de falha.
     */
    public function salvarArquivo(array $arquivo, string $prefixo): array
    {
        // Validação básica do arquivo
        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            return ['success' => false, 'erro' => 'Erro no upload do arquivo.'];
        }

        // Validação de tipo e extensão
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $tiposPermitidos = ['jpg', 'jpeg', 'png'];
        if (!in_array($extensao, $tiposPermitidos)) {
            return ['success' => false, 'erro' => 'Extensão de arquivo inválida. Apenas JPG, JPEG, PNG e GIF são permitidos.'];
        }

        // Validação de tamanho (ex: máximo de 5MB)
        if ($arquivo['size'] > 5 * 1024 * 1024) {
            return ['success' => false, 'erro' => 'O arquivo excede o tamanho máximo de 5MB.'];
        }

        // Gera um nome de arquivo único
        $nomeArquivo = $prefixo . '-' . uniqid() . '.' . $extensao;
        $caminhoCompleto = $this->diretorioUpload . $nomeArquivo;

        // Move o arquivo para o diretório de uploads
        if (move_uploaded_file($arquivo['tmp_name'], $caminhoCompleto)) {
            return ['success' => true, 'caminho' => 'Uploads/' . $nomeArquivo];
        } else {
            return ['success' => false, 'erro' => 'Falha ao salvar o arquivo.'];
        }
    }

    public function salvar(array $arquivo, string $prefixo, ?string $descricao = null)
    {

        $salvo = $this->salvarArquivo($arquivo, $prefixo);

        if(!$salvo['success'])return false;

        $id = $this->model->salvarImagem($salvo['caminho'], $descricao);

        return $id;
    }


    public function excluir(int $id)
    {
        if(!isset($id))return false;

        $imagem =  $this->model->buscarImagemPorId($id);

        if(!$imagem) return false;

        $excluido = $this->model->deletarImagem($imagem['imagem_id']);

        if(!$excluido)return false;

        return $this->excluirArquivo($imagem['url']);

    }
    public function excluirArquivo($path): bool
    {

        if(!isset($path) || !empty($path))return false;

        $caimnhoArquivo = $this->diretorioUpload . $path;

        if (!file_exists($caimnhoArquivo))return false;

        return unlink($caimnhoArquivo);
                       
    }
}
