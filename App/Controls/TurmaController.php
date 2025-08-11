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

            // --- INÍCIO DA VALIDAÇÃO OBRIGATÓRIA ---
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

            // Se houver erros, redireciona de volta com as mensagens
            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }
            // --- FIM DA VALIDAÇÃO OBRIGATÓRIA ---

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
                $_SESSION['sucesso_cadastro'] = "".htmlspecialchars($nome)." CADASTRADA COM SUCESSO !!!";
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
            if (!$turma_id) {
                // Redireciona se não houver ID
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                exit;
            }

            $turmaModel = new TurmaModel();
            
            // 1. BUSCA OS DADOS ANTIGOS DA TURMA ANTES DE QUALQUER AÇÃO
            $dadosAntigos = $turmaModel->buscarPorId($turma_id);
            if (!$dadosAntigos) {
                $_SESSION['erros_turma'] = ["Turma não encontrada para atualização."];
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                exit;
            }

            // Pega os novos dados do formulário
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = filter_input(INPUT_POST, 'imagem_id_atual', FILTER_VALIDATE_INT) ?: null;

            // --- Validação obrigatória (seu código existente) ---
            $erros = [];
            if (empty($nome)) {
                $erros[] = "O campo 'Nome' é obrigatório.";
            }
            if (empty($data_inicio)) {
                $erros[] = "O campo 'Início' é obrigatório.";
            }
            if ($polo_id === false || $polo_id <= 0) {
                $erros[] = "É obrigatório selecionar um 'Polo'.";
            }
            
            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . "cadastroTurmas/cadastroTurmas.php?id=$turma_id");
                exit;
            }
            // --- Fim da Validação ---

            // Lógica para salvar nova imagem (seu código existente)
            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $imagemModel = new ImagemModel();
                $nomeArquivo = uniqid() . '-' . basename($_FILES['imagem_turma']['name']);
                $caminhoDestino = __DIR__ . '/../View/assets/img/turmas/' . $nomeArquivo;
                $urlRelativa = 'App/View/assets/img/turmas/' . $nomeArquivo;
                if (move_uploaded_file($_FILES['imagem_turma']['tmp_name'], $caminhoDestino)) {
                    $novo_imagem_id = $imagemModel->salvarImagem($urlRelativa, "Imagem atualizada da turma " . $nome);
                    if ($novo_imagem_id) {
                        $imagem_id = $novo_imagem_id; // O ID da imagem é atualizado aqui
                    }
                }
            }

            // 2. COMPARA OS DADOS ANTIGOS COM OS NOVOS
            $camposAlterados = [];
            if ($dadosAntigos['nome'] != $nome) { $camposAlterados[] = 'Nome'; }
            if ($dadosAntigos['descricao'] != $descricao) { $camposAlterados[] = 'Descrição'; }
            if ($dadosAntigos['data_inicio'] != $data_inicio) { $camposAlterados[] = 'Data de Início'; }
            if ($dadosAntigos['data_fim'] != $data_fim) { $camposAlterados[] = 'Data de Fim'; }
            if ($dadosAntigos['polo_id'] != $polo_id) { $camposAlterados[] = 'Polo'; }
            // Compara o ID da imagem original com o ID final (que pode ter sido alterado pelo upload)
            if ($dadosAntigos['imagem_id'] != $imagem_id) { $camposAlterados[] = 'Imagem'; }


            // Executa a atualização no banco de dados
            $sucesso = $turmaModel->atualizarTurma($turma_id, $nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($sucesso) {
                // 3. CONSTRÓI A MENSAGEM DE SUCESSO
                $mensagem = "".htmlspecialchars($nome)." ATUALIZADA COM SUCESSO!!!";
                
                if (!empty($camposAlterados)) {
                    // Se houver campos alterados, adiciona a lista na mensagem
                    $mensagem .= " Campos alterados: " . implode(', ', $camposAlterados) . ".";
                } else {
                    // Opcional: informa que nada mudou
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

                // 1. Busca os dados da turma para obter o nome ANTES de excluir
                $turma = $turmaModel->buscarPorId($turma_id);
                $nomeDaTurma = $turma ? $turma['nome'] : ''; // Armazena o nome se a turma for encontrada

                // 2. Tenta excluir a turma
                if ($turmaModel->excluirTurma($turma_id)) {
                    // 3. Usa o nome na mensagem de sucesso
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