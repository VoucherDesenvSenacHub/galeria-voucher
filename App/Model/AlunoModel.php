<?php

require_once __DIR__ . "/BaseModel.php";

class AlunoModel extends BaseModel {

    public function __construct() {
        $this->tabela = "aluno";
        parent::__construct();
    }

    /**
     * Busca todos os alunos com seus respectivos polos.
     * @return array
     */
    public function buscarTodosAlunosComPolo(): array
    {
        $query = "
            SELECT
                p.pessoa_id,
                p.nome,
                polo.nome AS polo
            FROM
                pessoa p
            JOIN
                aluno_turma at ON p.pessoa_id = at.pessoa_id
            JOIN
                turma t ON at.turma_id = t.turma_id
            JOIN
                polo ON t.polo_id = polo.polo_id
            WHERE
                p.perfil = 'aluno'
            GROUP BY
                p.pessoa_id
            ORDER BY
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca todos os alunos de uma turma específica.
     * @param int $turma_id O ID da turma.
     * @return array
     */
    public function buscarAlunosPorTurma(int $turma_id): array
    {
        $query = "
            SELECT
                p.pessoa_id,
                p.nome,
                p.linkedin,
                p.github,
                i.url as imagem_url
            FROM
                pessoa p
            JOIN
                aluno_turma at ON p.pessoa_id = at.pessoa_id
            LEFT JOIN
                imagem i ON p.imagem_id = i.imagem_id
            WHERE
                at.turma_id = :turma_id
                AND p.perfil = 'aluno'
            ORDER BY
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarPorTurma(int $turmaId): array
    {
        $sql = "SELECT p.*, i.url AS foto 
                FROM aluno_turma at
                INNER JOIN pessoa p ON at.pessoa_id = p.pessoa_id
                LEFT JOIN imagem i ON p.imagem_id = i.imagem_id
                WHERE at.turma_id = :turma_id
                ORDER BY p.nome ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}