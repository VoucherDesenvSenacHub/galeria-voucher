<?php
require_once __DIR__ . '/BaseModel.php';

class ImagemProjetoDiaModel extends BaseModel
{

    public function __construct()
    {
        $this->tabela = "imagem_projeto_dia";
        parent::__construct();
    }

    /**
     * Busca todas as imagens associadas a um dia específico de um projeto.
     *
     * @param int $diaId O ID do dia do projeto (projeto_dia_id).
     * @return array Array de imagens associadas.
     */
    public function buscarPorProjetoDia(int $diaId): array
    {
        $sql = "
            SELECT
                i.imagem_id,
                i.url,
                i.text,
                i.descricao,
                i.data_upload
            FROM imagem_projeto_dia ipd
            JOIN imagem i ON ipd.imagem_id = i.imagem_id
            WHERE ipd.projeto_dia_id = :dia_id
            ORDER BY i.imagem_id ASC
        ";

        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':dia_id', $diaId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
             error_log("Erro ao buscar imagens por dia de projeto (ID: {$diaId}): " . $e->getMessage());
             return []; // Retorna array vazio em caso de erro
        }
    }

    /**
     * Associa uma imagem existente a um dia de projeto.
     *
     * @param int $imagemId O ID da imagem.
     * @param int $projetoDiaId O ID do dia do projeto.
     * @return bool True em caso de sucesso, false em caso de falha.
     */
    public function associarImagemDia(int $imagemId, int $projetoDiaId, int $projetoId): bool
    {
        $sql = "INSERT INTO imagem_projeto_dia (imagem_id, projeto_dia_id, projeto_id) VALUES (:imagem_id, :projeto_dia_id, :projeto_id)";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':imagem_id' => $imagemId,
                ':projeto_dia_id' => $projetoDiaId,
                ':projeto_id'=> $projetoId
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao associar imagem ID {$imagemId} ao dia de projeto ID {$projetoDiaId}: " . $e->getMessage());
            // Verifica se o erro é de chave duplicada (tentativa de inserir a mesma associação)
            if ($e->getCode() == '23000') {
                 // Considera sucesso se a associação já existe
                return true;
            }
            return false;
        }
    }

     /**
     * Desassocia uma imagem específica de um dia de projeto.
     *
     * @param int $imagemId O ID da imagem.
     * @param int $projetoDiaId O ID do dia do projeto.
     * @return bool True se a desassociação ocorreu (ou não existia), false em erro.
     */
    public function desassociarImagemDia(int $imagemId, int $projetoDiaId): bool
    {
        $sql = "DELETE FROM imagem_projeto_dia WHERE imagem_id = :imagem_id AND projeto_dia_id = :projeto_dia_id";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':imagem_id' => $imagemId,
                ':projeto_dia_id' => $projetoDiaId
            ]);
            return true; // Retorna true mesmo que a linha não exista (resultado desejado é a não existência)
        } catch (PDOException $e) {
            error_log("Erro ao desassociar imagem ID {$imagemId} do dia de projeto ID {$projetoDiaId}: " . $e->getMessage());
            return false;
        }
    }

     /**
      * Desassocia TODAS as imagens de um dia de projeto específico.
      * Útil ao deletar um dia de projeto.
      *
      * @param int $projetoDiaId O ID do dia do projeto.
      * @return bool True se sucesso, false em erro.
      */
     public function desassociarTodasImagensDoDia(int $projetoDiaId): bool
     {
         $sql = "DELETE FROM imagem_projeto_dia WHERE projeto_dia_id = :projeto_dia_id";
         try {
             $stmt = $this->pdo->prepare($sql);
             $stmt->execute([':projeto_dia_id' => $projetoDiaId]);
             return true;
         } catch (PDOException $e) {
             error_log("Erro ao desassociar todas as imagens do dia de projeto ID {$projetoDiaId}: " . $e->getMessage());
             return false;
         }
     }

}