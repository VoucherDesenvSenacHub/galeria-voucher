<?php
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/DocenteModel.php';
require_once __DIR__ . '/../Model/BaseModel.php';

class DocenteController {
    public function desvincularDocente() {
        // Verifica se o usuário está logado e é administrador
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'adm') {
            $_SESSION['erro'] = "Acesso negado. Apenas administradores podem realizar esta operação.";
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pessoa_id = filter_input(INPUT_POST, 'pessoa_id', FILTER_VALIDATE_INT);
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            
            if (!$pessoa_id || !$turma_id) {
                $_SESSION['erro'] = "Dados inválidos para desvinculação.";
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php?id=' . $turma_id);
                exit;
            }

            try {
                $docenteModel = new DocenteModel();
                $resultado = $docenteModel->desvincularDocenteDaTurma($pessoa_id, $turma_id);
                
                if ($resultado) {
                    $_SESSION['sucesso'] = "Docente desvinculado da turma com sucesso!";
                } else {
                    $_SESSION['erro'] = "Erro ao desvincular docente da turma.";
                }
                
            } catch (Exception $e) {
                $_SESSION['erro'] = "Erro interno: " . $e->getMessage();
            }
            
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php?id=' . $turma_id);
            exit;
        }
        
        // Se não for POST, redireciona
        header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php');
        exit;
    }
}

// Processa a requisição
if (isset($_GET['action'])) {
    $controller = new DocenteController();
    
    switch ($_GET['action']) {
        case 'desvincular':
            $controller->desvincularDocente();
            break;
        default:
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php');
            exit;
    }
}
?>
