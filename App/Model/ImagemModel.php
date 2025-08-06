<?php

require_once __DIR__ . '/BaseModel.php';

class ImagemModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Salva os dados de uma imagem no banco de dados.
     *
     * @param string $url O caminho relativo do arquivo da imagem.
     * @param string|null $descricao Uma descrição opcional para a imagem.
     * @return int|false O ID da imagem inserida ou false em caso de falha.
     */
    public function salvarImagem(string $url, ?string $descricao = null)
    {
        try {
            $query = "
                INSERT INTO imagem (url, descricao, data_upload) 
                VALUES (:url, :descricao, NOW())
            ";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([
                ':url' => $url,
                ':descricao' => $descricao
            ]);
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Erro ao salvar imagem no banco de dados: " . $e->getMessage());
            return false;
        }
    }
}