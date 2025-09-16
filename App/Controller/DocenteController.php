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
        ValidarLoginController::validarAdmin();

        $pessoa_id = filter_input(INPUT_POST, 'pessoa_id', FILTER_VALIDATE_INT);
        $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
        $senha = $_POST['senha'] ?? '';
        
        if (!$pessoa_id || !$turma_id) {
            $this->toJson([
                'status' => 'error',
                'mensagem' => 'Dados inválidos para desvinculação.'
            ], 400);
        }

        if (empty($senha)) {
            $this->toJson([
                'status' => 'error',
                'mensagem' => 'Senha é obrigatória para confirmar a desvinculação.'
            ], 400);
        }

        try {
            // Valida a senha do usuário logado
            $usuarioModel = new UsuarioModel();
            $usuarioLogado = $_SESSION['usuario'];
            $senhaValida = $usuarioModel->validarLogin($usuarioLogado['email'], $senha);
            
            if (!$senhaValida) {
                $this->toJson([
                    'status' => 'error',
                    'mensagem' => 'Senha incorreta. Desvinculação cancelada.'
                ], 401);
            }

            $docenteModel = new DocenteModel();
            $resultado = $docenteModel->desvincularDocenteDaTurma($pessoa_id, $turma_id);
            
            if ($resultado) {
                $this->toJson([
                    'status' => 'success',
                    'mensagem' => 'Docente desvinculado da turma com sucesso!',
                    'pessoa_id' => $pessoa_id,
                    'turma_id' => $turma_id
                ]);
            } else {
                $this->toJson([
                    'status' => 'error',
                    'mensagem' => 'Erro ao desvincular docente da turma.'
                ], 500);
            }
            
        } catch (Exception $e) {
            $this->toJson([
                'status' => 'error',
                'mensagem' => 'Erro interno: ' . $e->getMessage()
            ], 500);
        }
    }
}

// Processa a requisição
$controller = new DocenteController();
$controller->gerenciarRequisicao();
?>
