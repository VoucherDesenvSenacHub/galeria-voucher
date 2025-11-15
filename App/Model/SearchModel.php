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
        // Busca por pessoas (nome) e resolve turma via aluno_turma ou docente_turma
        $sqlPessoas = "
    SELECT 'pessoa' AS tipo,
           COALESCE(at.turma_id, dt.turma_id) AS turma_id,
           p.nome AS titulo,
           NULL AS descricao,
           p.perfil AS perfil
    FROM pessoa p
    LEFT JOIN aluno_turma at ON at.pessoa_id = p.pessoa_id
    LEFT JOIN docente_turma dt ON dt.pessoa_id = p.pessoa_id
    WHERE p.nome LIKE :q
    ORDER BY p.nome ASC
    LIMIT :lp
";
        $stmtP = $this->pdo->prepare($sqlPessoas);
        $like = "%" . $q . "%";
        $stmtP->bindValue(':q', $like, PDO::PARAM_STR);
        $stmtP->bindValue(':lp', (int) $this->limitPessoas, PDO::PARAM_INT);
        $stmtP->execute();
        $pessoasRaw = $stmtP->fetchAll(PDO::FETCH_ASSOC);

        // Filtra pessoas sem turma associada
        $pessoas = array_values(array_filter($pessoasRaw, function ($r) {
            return !empty($r['turma_id']);
        }));

        return $pessoas;
    }
}