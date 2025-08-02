<?php
class TurmaModel {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::conectar();
    }

    public function buscarTurmaPorId(int $id): ?array {
        $sql = "SELECT * FROM turma WHERE id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }
}
