<?php
require_once __DIR__ . '/../Model/AlunoModel.php';

$acao = $_GET['acao'] ?? '';

// --- LÓGICA PARA REQUISIÇÕES GET ---
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    switch ($acao) {
        case 'alunos':
            $model = new AlunoModel();
            $alunos = $model->buscarAlunos();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($alunos, JSON_UNESCAPED_UNICODE);
            exit(); // Usar exit() é uma boa prática após enviar JSON para garantir que nada mais seja executado.
        
        case 'alunoSemTurma':
            $model = new AlunoModel();
            $alunos = $model->buscarAlunosSemTurma();
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($alunos, JSON_UNESCAPED_UNICODE);
            exit();

        // O 'case teste' não faz sentido em um GET com dados de POST, foi removido daqui.
        
        default:
            // Se a ação não for encontrada em GET, não faz nada ou mostra um erro.
            break;
    }
}

// --- LÓGICA PARA REQUISIÇÕES POST ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($acao) {
        case 'teste':
            // CORREÇÃO 1: Renomeado para '$alunosSelecionadosIds' para clareza e consistência.
            $alunosSelecionadosIds = $_POST['pessoas'] ?? [];
            $turmaId = $_POST['Turmas'] ?? null;

            // CORREÇÃO 2: A condição 'if' agora usa o nome de variável correto.
            if (!empty($alunosSelecionadosIds) && !empty($turmaId)) {
                $alunoModel = new AlunoModel();
                try {
                    $sucesso = $alunoModel->cadastrarAlunosNaTurma($alunosSelecionadosIds, $turmaId);
                    
                    if ($sucesso) {
                        // O redirecionamento só acontece se o cadastro for bem-sucedido.
                        header('Location: /galeria-voucher/App/View/pages/adm/cadastroTurmas/alunos.php');
                        exit(); // É crucial usar exit() após um redirecionamento.
                    }
                } catch (Exception $e) {
                    // CORREÇÃO 3: Tratamento de exceção corrigido.
                    // Você pode logar o erro ou mostrar uma mensagem amigável.
                    error_log($e->getMessage()); // Salva o erro real no log do servidor.
                    // Redireciona para uma página de erro ou mostra uma mensagem.
                    die("Ocorreu um erro ao cadastrar os alunos. Por favor, tente novamente.");
                }
            } else {
                // Se não houver alunos ou turma, você pode redirecionar de volta com uma mensagem de erro.
                die("Nenhum aluno ou turma foi selecionado.");
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(['erro' => 'Ação POST não encontrada'], JSON_UNESCAPED_UNICODE);
            exit();
    }
}
?>