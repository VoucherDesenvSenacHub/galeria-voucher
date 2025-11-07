<?php
session_start();

require_once __DIR__ . '/../Config/App.php';
require_once __DIR__ . '/../Helpers/Redirect.php';
require_once __DIR__ . '/../Model/DocenteModel.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
require_once __DIR__ . '/BaseController.php';

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
        $action = $_GET['action'] ?? null;
        if (!$action) {
            $this->toJson(['status' => 'error', 'mensagem' => 'Ação não especificada.'], 400);
        }

        switch ($action) {
            case 'desvincular':
                $this->desvincularDocente();
                break;
            default:
                $this->toJson(['status' => 'error', 'mensagem' => 'Ação não reconhecida.'], 400);
        }
    }

    private function desvincularDocente(): void {
        if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['perfil'] !== 'adm') {
            $_SESSION['erro'] = "Acesso negado. Apenas administradores podem realizar esta operação.";
            Redirect::toAdm('turmas.php');
        }

        $pessoa_id = filter_input(INPUT_POST, 'pessoa_id', FILTER_VALIDATE_INT);
        $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
        $senha = $_POST['senha'] ?? '';
        
        $redirectParams = $turma_id ? ['id' => $turma_id] : [];

        if (!$pessoa_id || !$turma_id) {
            $_SESSION['erro'] = "Dados inválidos para desvinculação.";
            Redirect::toAdm('docentes.php', $redirectParams);
        }

        if (empty($senha)) {
            $_SESSION['erro'] = "Senha é obrigatória para confirmar a desvinculação.";
            Redirect::toAdm('docentes.php', $redirectParams);
        }

        try {
            $usuarioModel = new UsuarioModel();
            $usuarioLogado = $_SESSION['usuario'];
            $senhaValida = $usuarioModel->validarLogin($usuarioLogado['email'], $senha);
            
            if (!$senhaValida) {
                $_SESSION['erro'] = "Senha incorreta. Desvinculação cancelada.";
                Redirect::toAdm('docentes.php', $redirectParams);
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
        
        Redirect::toAdm('docentes.php', $redirectParams);
    }
}

$controller = new DocenteController();
$controller->gerenciarRequisicao();
?>