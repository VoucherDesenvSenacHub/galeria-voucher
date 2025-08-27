<?php

require_once __DIR__ . "/BaseModel.php";

class DocenteModel extends BaseModel {

    public function __construct() {
        $this->tabela = "docente";
        parent::__construct();
    }

    /**
     * Busca todos os docentes com seus respectivos polos.
     * @return array
     */
    public function buscarTodosDocentesComPolo(): array
    {
        $query = "
            SELECT 
                p.nome,
                polo.nome AS polo
            FROM 
                pessoa p
            JOIN 
                docente_turma dt ON p.pessoa_id = dt.pessoa_id
            JOIN 
                turma t ON dt.turma_id = t.turma_id
            JOIN
                polo ON t.polo_id = polo.polo_id
            WHERE
                p.perfil = 'professor'
            GROUP BY
                p.pessoa_id
            ORDER BY 
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarPorTurma(int $turmaId): array
    {
        $sql = "SELECT p.*, i.url AS foto 
                FROM docente_turma dt
                INNER JOIN pessoa p ON dt.pessoa_id = p.pessoa_id
                LEFT JOIN imagem i ON p.imagem_id = i.imagem_id
                WHERE dt.turma_id = :turma_id
                ORDER BY p.nome ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}