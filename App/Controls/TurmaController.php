<?php
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/TurmaModel.php';

class TurmaController {
    
    /**
     * Processa a criação de uma nova turma.
     */
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Validação simples dos dados recebidos
            $nome = trim($_POST['nome'] ?? '');
            $ano = trim($_POST['ano'] ?? ''); // O campo "Ano" pode ser parte da descrição ou do nome.
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $descricao = "Turma do ano de " . $ano; // Exemplo de como usar o ano.
            
            // Datas de início e fim (exemplo, podem vir do formulário)
            $data_inicio = date('Y-m-d'); // Data atual como exemplo
            $data_fim = null;

            $erros = [];
            if (empty($nome)) {
                $erros[] = "O campo 'Nome' é obrigatório.";
            }
            if (empty($ano)) {
                $erros[] = "O campo 'Ano da Turma' é obrigatório.";
            }
            if ($polo_id === false || $polo_id <= 0) {
                // Em um caso real, o polo viria de um <select> com IDs.
                // Por enquanto, vamos usar um ID fixo como exemplo, já que o front-end não envia o ID.
                $polo_id = 1; // Exemplo: Polo 'SENAC Centro'
            }

            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }

            // Instancia o modelo e tenta criar a turma
            $turmaModel = new TurmaModel();
            $resultado = $turmaModel->criarTurma($nome, $descricao, $data_inicio, $data_fim, $polo_id);

            if ($resultado) {
                $_SESSION['sucesso_turma'] = "Turma cadastrada com sucesso!";
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                exit;
            } else {
                $_SESSION['erros_turma'] = ["Ocorreu um erro ao salvar a turma. Tente novamente."];
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }
        }
    }
}

// Roteamento simples para a ação do controller
if (isset($_GET['action']) && $_GET['action'] === 'salvar') {
    $controller = new TurmaController();
    $controller->salvar();
}