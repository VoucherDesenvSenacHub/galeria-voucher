<?php
class ProjetoModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

    public function buscarProjetosPorTurma(int $turmaId): array
    {
        $sql = "SELECT * FROM projeto WHERE turma_id = :turmaId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turmaId', $turmaId, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $resultado ?: [];
    }

    public function buscarPorId(int $projetoId): ?array
    {
        $sql = "SELECT * FROM projeto WHERE projeto_id = :projetoId LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':projetoId', $projetoId, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ?: null;
    }
}
