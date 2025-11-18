<?php
session_start();

require_once __DIR__ . '/../Config/Config.php';
require_once __DIR__ . '/../Helpers/Redirect.php';
require_once __DIR__ . '/../Model/TurmaModel.php';

class VincularDocenteTurmaController
{

    public function vincular()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['erro'] = "Método não permitido.";
            Redirect::toAdm('turmas.php');
        }

        $turmaId = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
        $pessoaIds = $_POST['pessoas_ids'] ?? [];

        if (!$turmaId || !is_array($pessoaIds) || empty($pessoaIds)) {
            $_SESSION['erro'] = "Dados inválidos. Selecione ao menos um docente e tente novamente.";
            Redirect::toAdm('docentes.php', ['turma_id' => $turmaId]);
        }

        $turmaModel = new TurmaModel();
        $sucesso = true;
        foreach ($pessoaIds as $pessoaId) {
            if ($turmaModel->existeVinculoPessoaTurma((int)$pessoaId, (int)$turmaId)) {
                $sucesso = false;
                continue;
            }
            if (!$turmaModel->VincularDocenteComTurma((int)$pessoaId, (int)$turmaId)) {
                $sucesso = false;
                break;
            }
        }

        if ($sucesso) {
            $_SESSION['sucesso'] = "Docente(s) vinculado(s) com sucesso!";
        } elseif (!$sucesso) {
            $_SESSION['erro'] = "Um ou mais docentes já estão vinculados a esta turma.";
        } else {
            $_SESSION['erro'] = "Ocorreu um erro ao vincular os docentes. Tente novamente.";
        }

        Redirect::toAdm('docentes.php', ['turma_id' => $turmaId]);
    }
}

$controller = new VincularDocenteTurmaController();
$controller->vincular();
