<?php
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/AlunoModel.php';
require_once __DIR__ . '/../Model/BaseModel.php';

class  {
    DesvincularAlunoController
    public function desvincularAluno() {
        // Verifica se o usuário está logado e é administrador
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'adm') {
            $_SESSION['erro'] = "Acesso negado. Apenas administradores podem realizar esta operação.";
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pessoa_id = filter_input(INPUT_POST, 'pessoa_id', FILTER_VALIDATE_INT);
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            
            if (!$pessoa_id || !$turma_id) {
                $_SESSION['erro'] = "Dados inválidos para desvinculação.";
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/alunos.php?id=' . $turma_id);
                exit;
            }

            try {
                $alunoModel = new alunoModel();
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
