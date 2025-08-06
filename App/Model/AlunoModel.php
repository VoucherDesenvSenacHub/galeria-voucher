<?php
require_once __DIR__ . '/BaseModel.php';

class AlunoModel extends BaseModel
{
    public static $tabela = "aluno";

    public function __construct()
    {
        parent::__construct();
    }

    public function buscarPorTurma(int $turmaId): array
    {
        $sql = "SELECT p.*, i.url AS imagem 
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