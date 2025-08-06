<?php
require_once __DIR__ . '/BaseModel.php';

class TurmaModel extends BaseModel
{
    public static $tabela = "turma";

    public function __construct()
    {
        parent::__construct();
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
