<?php

require_once __DIR__ . '/../Config/Database.php';

header('Content-Type: application/json; charset=utf-8');

$q = isset($_GET['q']) ? trim($_GET['q']) : '';

if ($q === '' || mb_strlen($q) < 2) {
    echo json_encode([ 'results' => [] ]);
    exit;
}

try {
    $pdo = Database::conectar();

    // Limite por tipo para não sobrecarregar a UI
    $limitTurmas = 5;
    $limitPessoas = 5;

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
    $stmtT = $pdo->prepare($sqlTurmas);
    $like = "%" . $q . "%";
    $stmtT->bindValue(':q', $like, PDO::PARAM_STR);
    $stmtT->bindValue(':lt', (int)$limitTurmas, PDO::PARAM_INT);
    $stmtT->execute();
    $turmas = $stmtT->fetchAll(PDO::FETCH_ASSOC);

    // Busca por pessoas (nome) e resolve turma via aluno_turma ou docente_turma
    $sqlPessoas = "
        SELECT 'pessoa' AS tipo,
               COALESCE(at.turma_id, dt.turma_id) AS turma_id,
               p.nome AS titulo,
               NULL AS descricao
        FROM pessoa p
        LEFT JOIN aluno_turma at ON at.pessoa_id = p.pessoa_id
        LEFT JOIN docente_turma dt ON dt.pessoa_id = p.pessoa_id
        WHERE p.nome LIKE :q
        ORDER BY p.nome ASC
        LIMIT :lp
    ";
    $stmtP = $pdo->prepare($sqlPessoas);
    $stmtP->bindValue(':q', $like, PDO::PARAM_STR);
    $stmtP->bindValue(':lp', (int)$limitPessoas, PDO::PARAM_INT);
    $stmtP->execute();
    $pessoasRaw = $stmtP->fetchAll(PDO::FETCH_ASSOC);

    // Filtra pessoas sem turma associada
    $pessoas = array_values(array_filter($pessoasRaw, function ($r) {
        return !empty($r['turma_id']);
    }));

    // Normaliza saída
    $results = [];
    foreach ($turmas as $t) {
        $results[] = [
            'tipo' => 'turma',
            'titulo' => $t['titulo'],
            'turma_id' => (int)$t['turma_id'],
            'descricao' => $t['descricao'] ?? null
        ];
    }
    foreach ($pessoas as $p) {
        $results[] = [
            'tipo' => 'pessoa',
            'titulo' => $p['titulo'],
            'turma_id' => (int)$p['turma_id'],
            'descricao' => null
        ];
    }

    echo json_encode([ 'results' => $results ]);
} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode([ 'error' => 'Erro ao buscar', 'details' => $e->getMessage() ]);
}
