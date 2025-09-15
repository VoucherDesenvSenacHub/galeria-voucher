<?php

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

$nomeAluno =  $_Get['nome'] ?? $_POST['nome'] ?? '';
$nomeTurma =  $_Get['turma'] ?? $_POST['turma'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($acao) {
        case 'carregarTurma': {
                
            }
    }
}
session_start();

require_once __DIR__ . '/../Config/env.php';
require_once __DIR__ . '/../Model/TurmaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';

class TurmaController {
    
    private function slugify(string $text): string 
    {
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        $text = strtolower($text);
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        $text = preg_replace('/[\s-]+/', '-', $text);
        $text = trim($text, '-');
        return $text;
    }

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = null;

            $erros = []; 
            
            if (empty($nome)) {
                $erros[] = "O campo 'Nome da Turma' é obrigatório.";
            }
            if (empty($data_inicio)) {
                $erros[] = "O campo 'Início' é obrigatório.";
            }
            if ($polo_id === false || $polo_id <= 0) {
                $erros[] = "É obrigatório selecionar um 'Polo'.";
            }

            if (!empty($data_inicio) && !empty($data_fim)) {
                try {
                    $inicioObj = new DateTime($data_inicio);
                    $fimObj = new DateTime($data_fim);

                    if ($fimObj < $inicioObj) {
                        $erros[] = "A data de término não pode ser anterior à data de início.";
                    }
                } catch (Exception $e) {
                    $erros[] = "O formato de uma ou ambas as datas é inválido.";
                }
            }

            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $caminhoTemporario = $_FILES['imagem_turma']['tmp_name'];
                $infoImagem = @getimagesize($caminhoTemporario);
                
                $tiposPermitidos = ['image/jpeg', 'image/png'];

                if ($infoImagem === false || !in_array($infoImagem['mime'], $tiposPermitidos)) {
                    $erros[] = "Formato de imagem inválido. Apenas arquivos JPEG e PNG são permitidos.";
                }
            }
            
            
            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }

            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $imagemModel = new ImagemModel();
                
                $extensao = strtolower(pathinfo($_FILES['imagem_turma']['name'], PATHINFO_EXTENSION));
                $nomeBase = $this->slugify($nome);
                $nomeArquivo = $nomeBase . '-' . time() . '.' . $extensao;
                
                $diretorioDestino = __DIR__ . '/../View/assets/img/turmas/';
                // Verifica se o diretório existe, se não, tenta criar
                if (!is_dir($diretorioDestino)) {
                    mkdir($diretorioDestino, 0777, true);
                }

                $caminhoDestino = $diretorioDestino . $nomeArquivo;
                $urlRelativa = 'App/View/assets/img/turmas/' . $nomeArquivo;
                
                if (move_uploaded_file($_FILES['imagem_turma']['tmp_name'], $caminhoDestino)) {
                    $imagem_id = $imagemModel->salvarImagem($urlRelativa, "Imagem da turma " . $nome);
                }
            }

            $turmaModel = new TurmaModel();
            $resultado = $turmaModel->criarTurma($nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($resultado) {
                $_SESSION['sucesso_cadastro'] = "".htmlspecialchars($nome)." CADASTRADA COM SUCESSO !!!";
                // Redireciona para a página de edição da nova turma
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php?id=' . $resultado);
                exit;
            } else {
                $_SESSION['erros_turma'] = ["Ocorreu um erro ao salvar a turma."];
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }
        }
    }

    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            if (!$turma_id) {
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                exit;
            }

            $turmaModel = new TurmaModel();
            
            $dadosAntigos = $turmaModel->buscarTurmaPorId($turma_id);
            if (!$dadosAntigos) {
                $_SESSION['erros_turma'] = ["Turma não encontrada para atualização."];
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                exit;
            }

            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = filter_input(INPUT_POST, 'imagem_id_atual', FILTER_VALIDATE_INT) ?: null;

            $erros = [];
            if (empty($nome)) { $erros[] = "O campo 'Nome' é obrigatório."; }
            if (empty($data_inicio)) { $erros[] = "O campo 'Início' é obrigatório."; }
            if ($polo_id === false || $polo_id <= 0) { $erros[] = "É obrigatório selecionar um 'Polo'."; }
                
            if (!empty($data_inicio) && !empty($data_fim)) {
                // ... (lógica de validação de data idêntica à de salvar) ...
            }

            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $caminhoTemporario = $_FILES['imagem_turma']['tmp_name'];
                $infoImagem = @getimagesize($caminhoTemporario);
                
                $tiposPermitidos = ['image/jpeg', 'image/png'];

                if ($infoImagem === false || !in_array($infoImagem['mime'], $tiposPermitidos)) {
                    $erros[] = "Formato de imagem inválido. Apenas arquivos JPEG e PNG são permitidos.";
                }
            }
        
            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . "cadastroTurmas/cadastroTurmas.php?id=$turma_id");
                exit;
            }

            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $imagemModel = new ImagemModel();

                $extensao = strtolower(pathinfo($_FILES['imagem_turma']['name'], PATHINFO_EXTENSION));
                $nomeBase = $this->slugify($nome);
                $nomeArquivo = $nomeBase . '-' . time() . '.' . $extensao;
                
                $caminhoDestino = __DIR__ . '/../View/assets/img/turmas/' . $nomeArquivo;
                $urlRelativa = 'App/View/assets/img/turmas/' . $nomeArquivo;
                if (move_uploaded_file($_FILES['imagem_turma']['tmp_name'], $caminhoDestino)) {
                    $novo_imagem_id = $imagemModel->salvarImagem($urlRelativa, "Imagem atualizada da turma " . $nome);
                    if ($novo_imagem_id) {
                        $imagem_id = $novo_imagem_id; 
                    }
                }
            }

            $camposAlterados = [];
            if ($dadosAntigos['nome'] != $nome) { $camposAlterados[] = 'Nome'; }
            if ($dadosAntigos['descricao'] != $descricao) { $camposAlterados[] = 'Descrição'; }
            if ($dadosAntigos['data_inicio'] != $data_inicio) { $camposAlterados[] = 'Data de Início'; }
            if ($dadosAntigos['data_fim'] != $data_fim) { $camposAlterados[] = 'Data de Fim'; }
            if ($dadosAntigos['polo_id'] != $polo_id) { $camposAlterados[] = 'Polo'; }
            if ($dadosAntigos['imagem_id'] != $imagem_id) { $camposAlterados[] = 'Imagem'; }


            $sucesso = $turmaModel->atualizarTurma($turma_id, $nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($sucesso) {
                $mensagem = "".htmlspecialchars($nome)." ATUALIZADA COM SUCESSO!!!";
                
                if (!empty($camposAlterados)) {
                    $mensagem .= " Campos alterados: " . implode(', ', $camposAlterados) . ".";
                } else {
                    $mensagem .= " Nenhuma alteração foi Feita.";
                }
                $_SESSION['sucesso_edicao_alert'] = $mensagem;

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

                $turma = $turmaModel->buscarTurmaPorId($turma_id);
                $nomeDaTurma = $turma ? $turma['nome'] : '';

                if ($turmaModel->excluirTurma($turma_id)) {
                    $_SESSION['sucesso_exclusao'] = "" . htmlspecialchars($nomeDaTurma) . " EXCLUÍDA COM SUCESSO!!!";
                } else {
                    $_SESSION['erros_turma'] = ["Erro ao excluir a turma."];
                }
            }
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
            exit;
        }
    }
}

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

?>