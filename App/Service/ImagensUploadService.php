<?php

class ImagensUploadService
{
    private $diretorioUpload;
    private $tiposPermitidos = ['image/jpeg', 'image/png', 'image/gif'];
    private $tamanhoMaximo = 5 * 1024 * 1024; // 5 MB

    public function __construct()
    {
        // Define o diretório de uploads na raiz do projeto (sem a barra no final)
        $this->diretorioUpload = dirname(__DIR__, 2) . 'uploads';
        if (!is_dir($this->diretorioUpload)) {
            mkdir($this->diretorioUpload, 0777, true);
        }
    }

    public function salvar(array $arquivo, string $prefixo): array
    {
        if ($arquivo['error'] !== UPLOAD_ERR_OK) {
            if ($arquivo['error'] === UPLOAD_ERR_NO_TMP_DIR) {
                return ['sucesso' => false, 'mensagem' => 'Erro de servidor: Diretório temporário não encontrado.'];
            }
            return ['sucesso' => false, 'mensagem' => 'Ocorreu um erro no upload. Código: ' . $arquivo['error']];
        }

        $tipoReal = mime_content_type($arquivo['tmp_name']);
        if (!in_array($tipoReal, $this->tiposPermitidos)) {
            return ['sucesso' => false, 'mensagem' => 'Tipo de arquivo inválido. Apenas JPEG, PNG e GIF são permitidos.'];
        }

        if ($arquivo['size'] > $this->tamanhoMaximo) {
            return ['sucesso' => false, 'mensagem' => 'O arquivo excede o tamanho máximo de 5MB.'];
        }

        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $nomeArquivo = $prefixo . '-' . uniqid() . '-' . time() . '.' . $extensao;
        
        // Adiciona a barra separadora ao criar o caminho completo
        $caminhoDestino = $this->diretorioUpload . '/' . $nomeArquivo;

        if (!is_writable($this->diretorioUpload)) {
            return ['sucesso' => false, 'mensagem' => 'Erro de permissão: O servidor não pode escrever na pasta ' . $this->diretorioUpload];
        }

        if (move_uploaded_file($arquivo['tmp_name'], $caminhoDestino)) {
            // Retorna o caminho relativo para ser salvo no banco (com a barra)
            return ['sucesso' => true, 'caminho' => 'uploads/' . $nomeArquivo];
        } else {
            return ['sucesso' => false, 'mensagem' => 'Falha ao mover o arquivo para o destino. Verifique as permissões da pasta uploads.'];
        }
    }
}