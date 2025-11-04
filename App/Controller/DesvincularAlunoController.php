<?php
session_start();

require_once __DIR__ . '/../Config/App.php';
require_once __DIR__ . '/../Helpers/Redirect.php';
require_once __DIR__ . '/../Model/AlunoModel.php';
require_once __DIR__ . '/../Model/UsuarioModel.php';
require_once __DIR__ . '/ValidarLoginController.php';

class DesvincularAlunoController
{
    public function desvincularAluno()
    {
        ValidarLoginController::validarAdminRedirect(Config::get('DIR_ADM') . 'cadastro-turmas/alunos.php');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pessoa_id = filter_input(INPUT_POST, 'pessoa_id', FILTER_VALIDATE_INT);
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            $senha = $_POST['senha'] ?? '';
            
            $redirectParams = ['id' => $turma_id];

            if (!$pessoa_id || !$turma_id) {
                $_SESSION['erro'] = "Dados inválidos para desvinculação.";
                Redirect::toAdm('cadastro-turmas/alunos.php', $redirectParams);
            }

            if (empty($senha)) {
                $_SESSION['erro'] = "Senha é obrigatória para confirmar a desvinculação.";
                Redirect::toAdm('cadastro-turmas/alunos.php', $redirectParams);
            }

            try {
                $usuarioModel = new UsuarioModel();
                $usuarioLogado = $_SESSION['usuario'];
                $senhaValida = $usuarioModel->validarLogin($usuarioLogado['email'], $senha);
                
                if (!$senhaValida) {
                    $_SESSION['erro'] = "Senha incorreta. Desvinculação cancelada.";
                    Redirect::toAdm('cadastro-turmas/alunos.php', $redirectParams);
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
            
            Redirect::toAdm('cadastro-turmas/alunos.php', $redirectParams);
        }
        
        Redirect::toAdm('cadastro-turmas/alunos.php');
    }
}

if (isset($_GET['action'])) {
    $controller = new DesvincularAlunoController();
    
    switch ($_GET['action']) {
        case 'desvincular':
            $controller->desvincularAluno();
            break;
        default:
            Redirect::toAdm('cadastro-turmas/alunos.php');
    }
}
?>