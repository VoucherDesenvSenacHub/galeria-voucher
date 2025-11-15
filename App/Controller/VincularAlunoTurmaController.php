<?php
session_start();

require_once __DIR__ . '/../Config/Config.php';
require_once __DIR__ . '/../Helpers/Redirect.php';
require_once __DIR__ . '/../Model/TurmaModel.php';

class VincularAlunoTurmaController
{

    public function vincular()
    {

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['erro'] = "Método não permitido.";
            Redirect::toAdm('listaTurmas.php');
        }

        $turmaId = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
        $pessoaIds = $_POST['pessoas_ids'] ?? [];

        if (!$turmaId || !is_array($pessoaIds) || empty($pessoaIds)) {
            $_SESSION['erro'] = "Dados inválidos. Selecione ao menos um aluno e tente novamente.";
            Redirect::toAdm('alunos.php', ['turma_id' => $turmaId]);
        }

        $turmaModel = new TurmaModel();
        $sucesso = true;

        foreach ($pessoaIds as $pessoaId) {
            if ($turmaModel->existeVinculoPessoaTurma((int)$pessoaId, (int)$turmaId)) {
                $sucesso = false;
                break;
            }

            if (!$turmaModel->VincularAlunoComTurma((int) $pessoaId, (int) $turmaId)) {
                $sucesso = false;
                break;
            }
        }

        if ($sucesso) {
            $_SESSION['sucesso'] = "Aluno(s) vinculado(s) com sucesso!";
        } elseif (!$sucesso) {
            $_SESSION['erro'] = "Um ou mais docentes já estão vinculados a esta turma.";
        } else {
            $_SESSION['erro'] = "Ocorreu um erro ao vincular os alunos. Tente novamente.";
        }

        Redirect::toAdm('alunos.php', ['turma_id' => $turmaId]);
    }
}

$controller = new VincularAlunoTurmaController();
$controller->vincular();
