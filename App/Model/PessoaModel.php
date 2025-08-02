<?php
class PessoaModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

    public function buscarAlunosDaTurma(int $turmaId): array
    {
        $sql = "SELECT p.*, i.caminho AS imagem
                FROM pessoa p
                INNER JOIN aluno a ON a.pessoa_id = p.pessoa_id
                LEFT JOIN imagem i ON i.pessoa_id = p.pessoa_id
                WHERE a.turma_id = :turmaId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turmaId', $turmaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarDocentesDaTurma(int $turmaId): array
    {
        $sql = "SELECT p.*, i.caminho AS imagem
                FROM pessoa p
                INNER JOIN docente_turma dt ON dt.pessoa_id = p.pessoa_id
                LEFT JOIN imagem i ON i.pessoa_id = p.pessoa_id
                WHERE dt.turma_id = :turmaId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turmaId', $turmaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
