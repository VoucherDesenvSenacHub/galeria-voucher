<?php
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/TurmaModel.php';

class TurmaController {
    
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = null;

            $erros = [];
            if (empty($nome)) $erros[] = "O campo 'Nome' é obrigatório.";
            if (empty($data_inicio)) $erros[] = "A 'Data de Início' é obrigatória.";
            if ($polo_id === false || $polo_id <= 0) {
                $erros[] = "Por favor, selecione um Polo válido.";
            }
            
            if (!empty($data_fim) && $data_fim < $data_inicio) {
                $erros[] = "A data de fim não pode ser anterior à data de início.";
            }

            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }

            $turmaModel = new TurmaModel();
            $resultado = $turmaModel->criarTurma($nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($resultado) {
                $_SESSION['sucesso_turma'] = "Turma '".htmlspecialchars($nome)."' cadastrada com sucesso! Redirecionando...";
                // REDIRECIONA DE VOLTA PARA A PÁGINA DE CADASTRO
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            } else {
                $_SESSION['erros_turma'] = ["Ocorreu um erro inesperado ao salvar a turma. Tente novamente."];
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }
        }
    }
}

if (isset($_GET['action']) && $_GET['action'] === 'salvar') {
    $controller = new TurmaController();
    $controller->salvar();
}