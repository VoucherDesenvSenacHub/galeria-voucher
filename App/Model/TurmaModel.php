<?php
require_once __DIR__ . '/BaseModel.php';

class TurmaModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT t.*, i.url AS imagem 
                FROM turma t
                LEFT JOIN imagem i ON t.imagem_id = i.imagem_id
                WHERE t.turma_id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
