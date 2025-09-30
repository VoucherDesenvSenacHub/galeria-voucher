<?php
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/DocenteModel.php';
require_once __DIR__ . '/../Model/BaseModel.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
require_once __DIR__ . '/BaseController.php';
require_once __DIR__ . '/ValidarLoginController.php';

class DocenteController extends BaseController {
    protected array $metodosPermitidos = ['POST'];

    public function gerenciarRequisicao(): void {
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                $this->gerenciarPost();
                break;
            default:
                $this->gerenciarMetodosNaoPermitidos();
                break;
        }
    }

    private function gerenciarPost(): void {
        if (!isset($_GET['action'])) {
            $this->toJson([
                'status' => 'error',
                'mensagem' => 'Ação não especificada.'
            ], 400);
        }

        switch ($_GET['action']) {
            case 'desvincular':
                $this->desvincularDocente();
                break;
            default:
                $this->toJson([
                    'status' => 'error',
                    'mensagem' => 'Ação não reconhecida.'
                ], 400);
        }
    }

    private function desvincularDocente(): void {
        // Verifica se o usuário está logado e é administrador
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'adm') {
            $_SESSION['erro'] = "Acesso negado. Apenas administradores podem realizar esta operação.";
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php');
            exit;
        }

        $pessoa_id = filter_input(INPUT_POST, 'pessoa_id', FILTER_VALIDATE_INT);
        $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
        $senha = $_POST['senha'] ?? '';
        
        if (!$pessoa_id || !$turma_id) {
            $_SESSION['erro'] = "Dados inválidos para desvinculação.";
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php?id=' . $turma_id);
            exit;
        }

        if (empty($senha)) {
            $_SESSION['erro'] = "Senha é obrigatória para confirmar a desvinculação.";
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php?id=' . $turma_id);
            exit;
        }

        try {
            // Valida a senha do usuário logado
            $usuarioModel = new UsuarioModel();
            $usuarioLogado = $_SESSION['usuario'];
            $senhaValida = $usuarioModel->validarLogin($usuarioLogado['email'], $senha);
            
            if (!$senhaValida) {
                $_SESSION['erro'] = "Senha incorreta. Desvinculação cancelada.";
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php?id=' . $turma_id);
                exit;
            }

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
}

// Processa a requisição
$controller = new DocenteController();
$controller->gerenciarRequisicao();
?>
