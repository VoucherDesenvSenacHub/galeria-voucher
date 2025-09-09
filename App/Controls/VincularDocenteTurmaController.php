<?php 
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/TurmaModel.php';

class VincularDocenteTurmaController {
    
    public function vincular() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            $_SESSION['erro'] = "Método não permitido.";
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
            exit();
        }

        $turmaId = filter_input(INPUT_POST, 'turma_id');
        $pessoaIds = $_POST['pessoas_ids'] ?? [];

        if (!$turmaId || !is_array($pessoaIds) || empty($pessoaIds)) {
            $_SESSION['erro'] = "Dados inválidos. Selecione ao menos um docente e tente novamente.";
            exit();
        }

        $turmaModel = new TurmaModel();
        $sucesso = true;
        foreach ($pessoaIds as $pessoaId) {
            if (!$turmaModel->VincularDocenteComTurma((int)$pessoaId, (int)$turmaId)) {
                $sucesso = false;
                break;
            }
        }

        if ($sucesso) {
            $_SESSION['sucesso'] = "Docente(s) vinculado(s) com sucesso!";
        } else {
            $_SESSION['erro'] = "Ocorreu um erro ao vincular os docentes. Tente novamente.";
        }

        header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/docentes.php?id=' . $turmaId);
        exit();
    }
}

$controller = new VincularDocenteTurmaController();
$controller->vincular();