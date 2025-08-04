<?php
require_once __DIR__ . '/BaseModel.php';
class ImagemProjetoDiaModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

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

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':dia_id', $diaId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
