<?php
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/TurmaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php'; // Incluímos o novo modelo

class TurmaController {
    
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = null;

            // --- LÓGICA DE UPLOAD DA IMAGEM ---
            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $imagemModel = new ImagemModel();
                
                $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem_turma']['name']);
                $caminhoDestino = __DIR__ . '/../View/assets/img/turmas/' . $nomeArquivo;
                
                // Caminho relativo para salvar no banco de dados
                $urlRelativa = 'App/View/assets/img/turmas/' . $nomeArquivo;

                if (move_uploaded_file($_FILES['imagem_turma']['tmp_name'], $caminhoDestino)) {
                    $imagem_id = $imagemModel->salvarImagem($urlRelativa, "Imagem da turma " . $nome);
                    if (!$imagem_id) {
                         $_SESSION['erros_turma'] = ["Erro ao salvar as informações da imagem no banco de dados."];
                         header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                         exit;
                    }
                } else {
                    $_SESSION['erros_turma'] = ["Falha ao mover o arquivo de imagem."];
                    header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                    exit;
                }
            }
            // --- FIM DA LÓGICA DE UPLOAD ---

            $turmaModel = new TurmaModel();
            $resultado = $turmaModel->criarTurma($nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($resultado) {
                $_SESSION['sucesso_turma'] = "Turma '".htmlspecialchars($nome)."' cadastrada com sucesso! Redirecionando...";
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            } else {
                $_SESSION['erros_turma'] = ["Ocorreu um erro ao salvar a turma. Tente novamente."];
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