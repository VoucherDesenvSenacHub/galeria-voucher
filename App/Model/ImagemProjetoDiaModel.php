<?php

// Retire o declare(strict_types=1); daqui se ele estiver causando o erro
// declare(strict_types=1);

require_once __DIR__ . '/BaseModel.php';

class ImagemProjetoDiaModel extends BaseModel
{
    // REMOVE 'string' type hint here
    protected $tabela = "imagem_projeto_dia"; // <--- ESTA ERA A LINHA 8 COM ERRO

    public function __construct()
    {
        parent::__construct();
    }

    // ... (rest of the class methods remain the same) ...

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
             error_log("[buscarPorProjetoDia] ERRO PDO ao buscar imagens para dia ID {$diaId}: " . $e->getMessage());
             return [];
        }
    }

    /**
     * Associa uma imagem existente a um dia de projeto.
     *
     * @param int $imagemId O ID da imagem.
     * @param int $projetoDiaId O ID do dia do projeto.
     * @return bool True em caso de sucesso, false em caso de falha.
     */
    public function associarImagemDia(int $imagemId, int $projetoDiaId): bool
    {
        error_log("[associarImagemDia] Tentando associar imagem ID: {$imagemId} com projeto_dia ID: {$projetoDiaId}");

        $sql = "INSERT INTO {$this->tabela} (imagem_id, projeto_dia_id) VALUES (:imagem_id, :projeto_dia_id)"; // Use $this->tabela
        try {
            $stmt = $this->pdo->prepare($sql);
            $sucesso = $stmt->execute([
                ':imagem_id' => $imagemId,
                ':projeto_dia_id' => $projetoDiaId
            ]);

            if (!$sucesso) {
                 $errorInfo = $stmt->errorInfo();
                 error_log("[associarImagemDia] ERRO SQL (PDOStatement::errorInfo): Código SQLSTATE: " . ($errorInfo[0] ?? 'N/A') . " | Código Driver: " . ($errorInfo[1] ?? 'N/A') . " | Mensagem Driver: " . ($errorInfo[2] ?? 'Nenhuma mensagem específica'));
                 return false;
            }

            error_log("[associarImagemDia] Associação bem-sucedida para imagem ID {$imagemId} e dia ID {$projetoDiaId}.");
            return true;

        } catch (PDOException $e) {
            error_log("[associarImagemDia] ERRO PDOException: Código: " . $e->getCode() . " | Mensagem: " . $e->getMessage() . " | Trace: " . $e->getTraceAsString());
            if ($e->getCode() == '23000') {
                 error_log("[associarImagemDia] Aviso: Tentativa de inserir associação duplicada para imagem ID {$imagemId} e dia ID {$projetoDiaId}.");
                 // return true; // Decide if duplicates are allowed or should be treated as success
            }
            return false;
        } catch (Throwable $th) {
            error_log("[associarImagemDia] ERRO INESPERADO (Throwable): " . $th->getMessage() . " | Trace: " . $th->getTraceAsString());
            return false;
        }
    }


     /**
     * Desassocia uma imagem específica de um dia de projeto.
     */
    public function desassociarImagemDia(int $imagemId, int $projetoDiaId): bool
    {
        $sql = "DELETE FROM {$this->tabela} WHERE imagem_id = :imagem_id AND projeto_dia_id = :projeto_dia_id"; // Use $this->tabela
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':imagem_id' => $imagemId,
                ':projeto_dia_id' => $projetoDiaId
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Erro ao desassociar imagem ID {$imagemId} do dia de projeto ID {$projetoDiaId}: " . $e->getMessage());
            return false;
        }
    }

     /**
      * Desassocia TODAS as imagens de um dia de projeto específico.
      */
     public function desassociarTodasImagensDoDia(int $projetoDiaId): bool
     {
         $sql = "DELETE FROM {$this->tabela} WHERE projeto_dia_id = :projeto_dia_id"; // Use $this->tabela
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