<?php
class ProjetoModel {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::conectar();
    }

    public function buscarProjetosPorTurma(int $turmaId): array {
        $sql = "SELECT * FROM projeto WHERE turma_id = :turmaId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turmaId', $turmaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


