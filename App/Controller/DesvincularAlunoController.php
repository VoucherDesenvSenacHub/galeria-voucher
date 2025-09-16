<?php
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/AlunoModel.php';
require_once __DIR__ . '/../Model/BaseModel.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
require_once __DIR__ . '/ValidarLoginController.php';

class DesvincularAlunoController {
    public function desvincularAluno() {
        // Verifica se o usuário está logado e é administrador
        $urlRedirecionamento = VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php';
        ValidarLoginController::validarAdminRedirect($urlRedirecionamento);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pessoa_id = filter_input(INPUT_POST, 'pessoa_id', FILTER_VALIDATE_INT);
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            $senha = $_POST['senha'] ?? '';
            
            if (!$pessoa_id || !$turma_id) {
                $_SESSION['erro'] = "Dados inválidos para desvinculação.";
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php?id=' . $turma_id);
                exit;
            }

            if (empty($senha)) {
                $_SESSION['erro'] = "Senha é obrigatória para confirmar a desvinculação.";
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php?id=' . $turma_id);
                exit;
            }

            try {
                // Valida a senha do usuário logado
                $usuarioModel = new UsuarioModel();
                $usuarioLogado = $_SESSION['usuario'];
                $senhaValida = $usuarioModel->validarLogin($usuarioLogado['email'], $senha);
                
                if (!$senhaValida) {
                    $_SESSION['erro'] = "Senha incorreta. Desvinculação cancelada.";
                    header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php?id=' . $turma_id);
                    exit;
                }

                $alunoModel = new AlunoModel();
                $resultado = $alunoModel->desvincularAlunoDaTurma($pessoa_id, $turma_id);
                
                if ($resultado) {
                    $_SESSION['sucesso'] = "Aluno desvinculado da turma com sucesso!";
                } else {
                    $_SESSION['erro'] = "Erro ao desvincular aluno da turma.";
                }
                
            } catch (Exception $e) {
                $_SESSION['erro'] = "Erro interno: " . $e->getMessage();
            }
            
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php?id=' . $turma_id);
            exit;
        }
        
        // Se não for POST, redireciona
        header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php');
        exit;
    }
}

// Processa a requisição
if (isset($_GET['action'])) {
    $controller = new DesvincularAlunoController();
    
    switch ($_GET['action']) {
        case 'desvincular':
            $controller->desvincularAluno();
            break;
        default:
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php');
            exit;
    }
}
?>
