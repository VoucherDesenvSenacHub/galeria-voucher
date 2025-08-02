<?php
class DocenteModel {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::conectar();
    }

    public function buscarDocentesPorTurma(int $turmaId): array {
        $sql = "
            SELECT d.*, p.nome, p.email, i.caminho AS imagem
            FROM docente d
            JOIN pessoa p ON d.pessoa_id = p.pessoa_id
            LEFT JOIN imagem i ON p.pessoa_id = i.pessoa_id
            WHERE d.turma_id = :turmaId
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turmaId', $turmaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
