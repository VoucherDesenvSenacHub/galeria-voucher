




























































































































































































<?php

require_once __DIR__ . "/BaseModel.php";

class PessoaModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca todas as pessoas com seus respectivos polos e perfis.
     * @return array
     */
    public function buscarTodasPessoasComPolo(): array
    {
        $query = "
            SELECT
                p.pessoa_id,
                p.nome,
                p.perfil AS tipo,
                COALESCE(polo_aluno.nome, polo_docente.nome, 'N/A') AS polo
            FROM
                pessoa p
            LEFT JOIN (
                SELECT at.pessoa_id, po.nome
                FROM aluno_turma at
                JOIN turma t ON at.turma_id = t.turma_id
                JOIN polo po ON t.polo_id = po.polo_id
                GROUP BY at.pessoa_id, po.nome
            ) AS polo_aluno ON p.pessoa_id = polo_aluno.pessoa_id
            LEFT JOIN (
                SELECT dt.pessoa_id, po.nome
                FROM docente_turma dt
                JOIN turma t ON dt.turma_id = t.turma_id
                JOIN polo po ON t.polo_id = po.polo_id
                GROUP BY dt.pessoa_id, po.nome
            ) AS polo_docente ON p.pessoa_id = polo_docente.pessoa_id
            ORDER BY
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}