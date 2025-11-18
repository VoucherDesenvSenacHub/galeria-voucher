<?php

require_once __DIR__ . "/BaseModel.php";

class SearchModel extends BaseModel
{
    private $limitTurmas;
    private $limitPessoas;

    public function __construct()
    {
        parent::__construct();
        $this->limitTurmas = 5;
        $this->limitPessoas = 5;
    }

    public function searchTurmas($q)
    {
        // Busca por turmas (nome e descrição)
        $sqlTurmas = "
        SELECT 'turma' AS tipo,
               t.turma_id,
               t.nome AS titulo,
               t.descricao AS descricao
        FROM turma t
        WHERE t.nome LIKE :q OR t.descricao LIKE :q
        ORDER BY t.nome ASC
        LIMIT :lt
    ";
        $stmtT = $this->pdo->prepare($sqlTurmas);
        $like = "%" . $q . "%";
        $stmtT->bindValue(':q', $like, PDO::PARAM_STR);
        $stmtT->bindValue(':lt', (int) $this->limitTurmas, PDO::PARAM_INT);
        $stmtT->execute();
        $turmas = $stmtT->fetchAll(PDO::FETCH_ASSOC);

        return $turmas;
    }

    public function searchPessoas($q)
    {
        $sql = "
            SELECT 
                'pessoa' AS tipo,
                pt.turma_id AS turma_id,
                p.nome AS titulo,
                p.perfil AS perfil
            FROM pessoa p
            
            -- pega pessoas que estão em alguma turma (aluno ou docente)
            INNER JOIN (
                SELECT pessoa_id, turma_id FROM aluno_turma
                UNION
                SELECT pessoa_id, turma_id FROM docente_turma
            ) AS pt ON pt.pessoa_id = p.pessoa_id

            WHERE p.nome LIKE :q
            GROUP BY p.pessoa_id
            ORDER BY p.nome ASC
            LIMIT :lp
        ";

        $stmt = $this->pdo->prepare($sql);
        $like = "%" . $q . "%";
        $stmt->bindValue(':q', $like, PDO::PARAM_STR);
        $stmt->bindValue(':lp', (int)$this->limitPessoas, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}