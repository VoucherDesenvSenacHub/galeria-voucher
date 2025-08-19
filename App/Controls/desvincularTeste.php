<?php
require_once __DIR__ . '/../../../Model/AlunoModel.php';
require_once __DIR__ . '/../../../Model/TurmaModel.php';
require_once __DIR__ . '/../../../Model/UsuarioModel.php'; // Para validar senha

session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Método não permitido']);
    exit;
}

$alunoId = $_POST['aluno_id'] ?? null;
$confirmarExclusao = $_POST['confirmar'] ?? 'nao'; // 'sim' ou 'nao'
$senha = $_POST['senha'] ?? null;

if (!$alunoId) {
    echo json_encode(['error' => 'ID do aluno é obrigatório']);
    exit;
}

$alunoModel = new AlunoModel();
$turmaModel = new TurmaModel();
$usuarioModel = new UsuarioModel();

// 1) Verificar vínculo do aluno com alguma turma
$vinculado = $turmaModel->verificarAlunoVinculado($alunoId);

if ($vinculado && $confirmarExclusao === 'nao') {
    // Retorna para o front a necessidade de confirmação para desvincular
    echo json_encode([
        'status' => 'confirmar_desvinculo',
        'mensagem' => 'Aluno está vinculado a uma turma. Deseja desvincular?'
    ]);
    exit;
}

// 2) Se não está vinculado ou o usuário confirmou desvincular/exclusão:

if (!$senha) {
    echo json_encode(['error' => 'Senha é obrigatória para excluir aluno']);
    exit;
}

// 3) Validar senha do usuário (supondo que você tenha o id do usuário logado na sessão)
$usuarioId = $_SESSION['usuario_id'] ?? null;
if (!$usuarioId || !$usuarioModel->validarSenha($usuarioId, $senha)) {
    echo json_encode(['error' => 'Senha incorreta']);
    exit;
}

// 4) Se estiver vinculado, desvincula o aluno da turma antes de excluir
if ($vinculado) {
    $turmaModel->desvincularAluno($alunoId);
}

// 5) Excluir o aluno
if ($alunoModel->deletarAluno($alunoId)) {
    echo json_encode(['status' => 'sucesso', 'mensagem' => 'Aluno excluído com sucesso']);
} else {
    echo json_encode(['error' => 'Erro ao excluir aluno']);
}
