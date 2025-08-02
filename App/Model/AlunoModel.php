<?php
class AlunoModel {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::conectar();
    }

    public function buscarAlunosPorTurma(int $turmaId): array {
        $sql = "
            SELECT a.*, p.nome, p.email, i.caminho AS imagem
            FROM aluno a
            JOIN pessoa p ON a.pessoa_id = p.pessoa_id
            LEFT JOIN imagem i ON p.pessoa_id = i.pessoa_id
            WHERE a.turma_id = :turmaId
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turmaId', $turmaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
