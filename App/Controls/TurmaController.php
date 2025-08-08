<?php
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/TurmaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';

class TurmaController {
    
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = null;

            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $imagemModel = new ImagemModel();
                $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem_turma']['name']);
                $caminhoDestino = __DIR__ . '/../View/assets/img/turmas/' . $nomeArquivo;
                $urlRelativa = 'App/View/assets/img/turmas/' . $nomeArquivo;
                if (move_uploaded_file($_FILES['imagem_turma']['tmp_name'], $caminhoDestino)) {
                    $imagem_id = $imagemModel->salvarImagem($urlRelativa, "Imagem da turma " . $nome);
                }
            }

            $turmaModel = new TurmaModel();
            $resultado = $turmaModel->criarTurma($nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($resultado) {
                $_SESSION['sucesso_cadastro'] = "Turma '".htmlspecialchars($nome)."' CADASTRADA COM SUCESSO !!!";
            } else {
                $_SESSION['erros_turma'] = ["Ocorreu um erro ao salvar a turma."];
            }
            
            // REDIRECIONA DE VOLTA PARA A PÁGINA DE CADASTRO
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
            exit;
        }
    }

    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = filter_input(INPUT_POST, 'imagem_id_atual', FILTER_VALIDATE_INT) ?: null;

            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $imagemModel = new ImagemModel();
                $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem_turma']['name']);
                $caminhoDestino = __DIR__ . '/../View/assets/img/turmas/' . $nomeArquivo;
                $urlRelativa = 'App/View/assets/img/turmas/' . $nomeArquivo;
                if (move_uploaded_file($_FILES['imagem_turma']['tmp_name'], $caminhoDestino)) {
                    $novo_imagem_id = $imagemModel->salvarImagem($urlRelativa, "Imagem atualizada da turma " . $nome);
                    if ($novo_imagem_id) {
                        $imagem_id = $novo_imagem_id;
                    }
                }
            }

            $turmaModel = new TurmaModel();
            $sucesso = $turmaModel->atualizarTurma($turma_id, $nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($sucesso) {
                // USA UMA CHAVE ESPECÍFICA PARA O ALERT DE EDIÇÃO
                $_SESSION['sucesso_edicao_alert'] = "Turma '".htmlspecialchars($nome)."' atualizada com sucesso!";
            } else {
                $_SESSION['erros_turma'] = ["Erro ao atualizar a turma."];
            }
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . "cadastroTurmas/cadastroTurmas.php?id=$turma_id");
            exit;
        }
    }

    public function excluir() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            if ($turma_id) {
                $turmaModel = new TurmaModel();
                if ($turmaModel->excluirTurma($turma_id)) {
                    // Chave de sessão específica para EXCLUSÃO
                    $_SESSION['sucesso_exclusao'] = "Turma excluída com sucesso!";
                } else {
                    $_SESSION['erros_turma'] = ["Erro ao excluir a turma."];
                }
            }
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
            exit;
        }
    }
}

// Roteamento para as ações
if (isset($_GET['action'])) {
    $controller = new TurmaController();
    switch ($_GET['action']) {
        case 'salvar':
            $controller->salvar();
            break;
        case 'atualizar':
            $controller->atualizar();
            break;
        case 'excluir':
            $controller->excluir();
            break;
    }
}