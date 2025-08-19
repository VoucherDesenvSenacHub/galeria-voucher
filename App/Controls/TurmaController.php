<?php
// Inicia ou resume uma sessão. Essencial para usar a superglobal $_SESSION
// para transportar mensagens de erro/sucesso entre requisições (flash messages).
session_start();

// Carrega as variáveis de ambiente (como URL da aplicação, credenciais de banco, etc.).
require_once __DIR__ . '/../Config/env.php';
// Inclui as classes de Model necessárias para que o Controller possa interagir com o banco.
require_once __DIR__ . '/../Model/TurmaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';

/**
 * Classe TurmaController
 * Orquestra as ações relacionadas à entidade Turma. Recebe dados do usuário,
 * valida-os, interage com os Models e direciona o fluxo da aplicação.
 */
class TurmaController {
    
    
    /**
     * FUNÇÃO AUXILIAR PARA FORMATAR O NOME DA IMAGEM
     * Converte uma string para um formato "slug" amigável para URL.
     * Ex: "Programação Web 2025" se torna "programacao-web-2025".
     * @param string $text O texto a ser formatado.
     * @return string O texto formatado.
     */
    private function slugify(string $text): string 
    {
        // Remove acentos
        $text = iconv('UTF-8', 'ASCII//TRANSLIT', $text);
        // Converte para minúsculas
        $text = strtolower($text);
        // Remove caracteres que não são letras, números, espaços ou hífens
        $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
        // Substitui espaços e múltiplos hífens por um único hífen
        $text = preg_replace('/[\s-]+/', '-', $text);
        // Remove hífens do início e do fim
        $text = trim($text, '-');
        return $text;
    }

    /**
     * Processa a criação (salvamento) de uma nova turma.
     * Lida com a submissão de um formulário de cadastro.
     */
    public function salvar() {
        // Garante que o método só seja executado se a requisição for do tipo POST,
        // que é o método padrão para envio de formulários que alteram dados.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // --- COLETA E LIMPEZA DOS DADOS DO FORMULÁRIO ---
            // trim() remove espaços em branco do início e do fim.
            // O operador '??' (null coalescing) define um valor padrão ('') se o campo não existir.
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            // Define data_fim como null se o campo estiver vazio, para consistência com o banco.
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            // filter_input é uma forma segura de obter e validar dados de fontes externas.
            // Aqui, garante que polo_id seja um inteiro válido.
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = null; // Inicializa imagem_id como nulo. Será alterado se um upload ocorrer.

           // --- INÍCIO DA VALIDAÇÃO DOS DADOS ---
            $erros = []; // Array para acumular todas as mensagens de erro.
            
            // 1. Valida se os campos obrigatórios foram preenchidos.
            if (empty($nome)) {
                $erros[] = "O campo 'Nome da Turma' é obrigatório.";
            }
            if (empty($data_inicio)) {
                $erros[] = "O campo 'Início' é obrigatório.";
            }
            if ($polo_id === false || $polo_id <= 0) { // filter_input retorna false em falha de validação.
                $erros[] = "É obrigatório selecionar um 'Polo'.";
            }

            // 2. Valida a lógica das datas (só se ambas foram enviadas).
            if (!empty($data_inicio) && !empty($data_fim)) {
                try {
                    // Cria objetos DateTime para comparar as datas de forma segura.
                    $inicioObj = new DateTime($data_inicio);
                    $fimObj = new DateTime($data_fim);

                    if ($fimObj < $inicioObj) {
                        $erros[] = "A data de término não pode ser anterior à data de início.";
                    }
                } catch (Exception $e) {
                    // Captura exceções se o formato da data for inválido (ex: "2023-99-99").
                    $erros[] = "O formato de uma ou ambas as datas é inválido.";
                }
            }

            // 3. Validação da Imagem
            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $caminhoTemporario = $_FILES['imagem_turma']['tmp_name'];
                $infoImagem = @getimagesize($caminhoTemporario);
                
                $tiposPermitidos = ['image/jpeg', 'image/png'];

                if ($infoImagem === false || !in_array($infoImagem['mime'], $tiposPermitidos)) {
                    $erros[] = "Formato de imagem inválido. Apenas arquivos JPEG e PNG são permitidos.";
                }
            }
            
            
            // 4. VERIFICAÇÃO FINAL: Se o array de erros não estiver vazio, algo deu errado.
            if (!empty($erros)) {
                // Armazena os erros na sessão para que possam ser exibidos na página do formulário.
                $_SESSION['erros_turma'] = $erros;
                // Redireciona o usuário de volta para a página de cadastro.
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                // Interrompe a execução do script para garantir que o redirecionamento ocorra imediatamente.
                exit;
            }
            // --- FIM DA VALIDAÇÃO ---

            // --- PROCESSAMENTO DO UPLOAD DA IMAGEM ---
            // Verifica se um arquivo foi enviado (`isset`) e se o upload ocorreu sem erros.
            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $imagemModel = new ImagemModel();

                // 2. Lógica de nomeação do Arquivo
                // Pega a extensão original do arquivo (ex: 'png')
                $extensao = strtolower(pathinfo($_FILES['imagem_turma']['name'], PATHINFO_EXTENSION));
                // Cria um nome base usando o nome da turma formatado pela nossa função
                $nomeBase = $this->slugify($nome);
                // Monta o nome final com o timestamp para garantir que seja único
                $nomeArquivo = $nomeBase . '-' . time() . '.' . $extensao;
                

                // Define o caminho absoluto no servidor onde o arquivo será salvo.
                $caminhoDestino = __DIR__ . '/../View/assets/img/turmas/' . $nomeArquivo;
                // Define a URL relativa que será salva no banco de dados.
                $urlRelativa = 'App/View/assets/img/turmas/' . $nomeArquivo;
                
                // Tenta mover o arquivo temporário para o destino final.
                if (move_uploaded_file($_FILES['imagem_turma']['tmp_name'], $caminhoDestino)) {
                    // Se o arquivo foi movido com sucesso, salva o registro no banco
                    // e armazena o ID retornado na variável $imagem_id.
                    $imagem_id = $imagemModel->salvarImagem($urlRelativa, "Imagem da turma " . $nome);
                }
            }

            // --- SALVANDO A TURMA NO BANCO ---
            $turmaModel = new TurmaModel();
            $resultado = $turmaModel->criarTurma($nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            // --- FEEDBACK PARA O USUÁRIO ---
            if ($resultado) {
                // Se a criação foi bem-sucedida, cria uma mensagem de sucesso na sessão.
                // htmlspecialchars() previne ataques XSS ao exibir o nome da turma.
                $_SESSION['sucesso_cadastro'] = "".htmlspecialchars($nome)." CADASTRADA COM SUCESSO !!!";
            } else {
                // Se falhou, cria uma mensagem de erro genérica.
                $_SESSION['erros_turma'] = ["Ocorreu um erro ao salvar a turma."];
            }
            
            // Redireciona de volta para a página de cadastro, que irá mostrar a mensagem de sucesso/erro.
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
            exit;
        }
    }

    /**
     * Processa a atualização de uma turma existente.
     * Lida com a submissão de um formulário de edição.
     */
    public function atualizar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Obtém e valida o ID da turma que está sendo editada.
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            if (!$turma_id) {
                // Se o ID for inválido ou não existir, redireciona para a lista de turmas.
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                exit;
            }

            $turmaModel = new TurmaModel();
            
            // 1. Busca os dados atuais da turma no banco ANTES de qualquer alteração.
            // Isso é crucial para comparar o que foi alterado.
            $dadosAntigos = $turmaModel->buscarTurmaPorId($turma_id);
            if (!$dadosAntigos) {
                $_SESSION['erros_turma'] = ["Turma não encontrada para atualização."];
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                exit;
            }

            // Pega os novos dados do formulário (mesma lógica do método salvar).
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            // Pega o ID da imagem atual. Se o usuário enviar uma nova, este valor será substituído.
            $imagem_id = filter_input(INPUT_POST, 'imagem_id_atual', FILTER_VALIDATE_INT) ?: null;

            // --- Validação (lógica idêntica ao método salvar) ---
            $erros = [];
            if (empty($nome)) { $erros[] = "O campo 'Nome' é obrigatório."; }
            if (empty($data_inicio)) { $erros[] = "O campo 'Início' é obrigatório."; }
            if ($polo_id === false || $polo_id <= 0) { $erros[] = "É obrigatório selecionar um 'Polo'."; }
                
            if (!empty($data_inicio) && !empty($data_fim)) {
                // ... (lógica de validação de data idêntica à de salvar) ...
            }

            // ▼▼▼ NOVA VALIDAÇÃO DE IMAGEM ▼▼▼
            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $caminhoTemporario = $_FILES['imagem_turma']['tmp_name'];
                $infoImagem = @getimagesize($caminhoTemporario);
                
                $tiposPermitidos = ['image/jpeg', 'image/png'];

                if ($infoImagem === false || !in_array($infoImagem['mime'], $tiposPermitidos)) {
                    $erros[] = "Formato de imagem inválido. Apenas arquivos JPEG e PNG são permitidos.";
                }
            }
            // ▲▲▲ FIM DA VALIDAÇÃO DE IMAGEM ▲▲▲
        
            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                // Redireciona de volta para a PÁGINA DE EDIÇÃO da turma específica.
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . "cadastroTurmas/cadastroTurmas.php?id=$turma_id");
                exit;
            }
            // --- Fim da Validação ---

            // --- Lógica para salvar nova imagem (idêntica ao método salvar) ---
            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] === UPLOAD_ERR_OK) {
                $imagemModel = new ImagemModel();

                // ▼▼▼ 2. LÓGICA DE NOMEAÇÃO DO ARQUIVO ATUALIZADA (IDÊNTICA À DO MÉTODO SALVAR) ▼▼▼
                $extensao = strtolower(pathinfo($_FILES['imagem_turma']['name'], PATHINFO_EXTENSION));
                $nomeBase = $this->slugify($nome);
                $nomeArquivo = $nomeBase . '-' . time() . '.' . $extensao;
                // ▲▲▲ FIM DA ATUALIZAÇÃO ▲▲▲
                
                $caminhoDestino = __DIR__ . '/../View/assets/img/turmas/' . $nomeArquivo;
                $urlRelativa = 'App/View/assets/img/turmas/' . $nomeArquivo;
                if (move_uploaded_file($_FILES['imagem_turma']['tmp_name'], $caminhoDestino)) {
                    $novo_imagem_id = $imagemModel->salvarImagem($urlRelativa, "Imagem atualizada da turma " . $nome);
                    if ($novo_imagem_id) {
                        // Se uma nova imagem foi salva, ATUALIZA a variável $imagem_id com o novo ID.
                        $imagem_id = $novo_imagem_id; 
                    }
                }
            }

            // 2. COMPARA os dados antigos com os novos para gerar uma mensagem de sucesso informativa.
            $camposAlterados = [];
            if ($dadosAntigos['nome'] != $nome) { $camposAlterados[] = 'Nome'; }
            if ($dadosAntigos['descricao'] != $descricao) { $camposAlterados[] = 'Descrição'; }
            if ($dadosAntigos['data_inicio'] != $data_inicio) { $camposAlterados[] = 'Data de Início'; }
            if ($dadosAntigos['data_fim'] != $data_fim) { $camposAlterados[] = 'Data de Fim'; }
            if ($dadosAntigos['polo_id'] != $polo_id) { $camposAlterados[] = 'Polo'; }
            if ($dadosAntigos['imagem_id'] != $imagem_id) { $camposAlterados[] = 'Imagem'; }


            // Executa a atualização no banco de dados com os dados novos (incluindo o possível novo imagem_id).
            $sucesso = $turmaModel->atualizarTurma($turma_id, $nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($sucesso) {
                // 3. CONSTRÓI A MENSAGEM DE SUCESSO baseada nas alterações.
                $mensagem = "".htmlspecialchars($nome)." ATUALIZADA COM SUCESSO!!!";
                
                if (!empty($camposAlterados)) {
                    // Se algo mudou, lista os campos.
                    $mensagem .= " Campos alterados: " . implode(', ', $camposAlterados) . ".";
                } else {
                    // Se nada mudou, informa o usuário.
                    $mensagem .= " Nenhuma alteração foi Feita.";
                }
                $_SESSION['sucesso_edicao_alert'] = $mensagem;

            } else {
                $_SESSION['erros_turma'] = ["Erro ao atualizar a turma."];
            }
            // Redireciona de volta para a página de edição para que o usuário veja o resultado.
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . "cadastroTurmas/cadastroTurmas.php?id=$turma_id");
            exit;
        }
    }


   /**
    * Processa a exclusão de uma turma.
    */
   public function excluir() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            if ($turma_id) {
                $turmaModel = new TurmaModel();

                // 1. Busca os dados da turma para obter o nome ANTES de excluí-la.
                // Isso permite usar o nome na mensagem de sucesso.
                $turma = $turmaModel->buscarTurmaPorId($turma_id);
                $nomeDaTurma = $turma ? $turma['nome'] : '';

                // 2. Tenta excluir a turma (o Model cuida da transação e das dependências).
                if ($turmaModel->excluirTurma($turma_id)) {
                    // 3. Usa o nome guardado na mensagem de sucesso.
                    $_SESSION['sucesso_exclusao'] = "" . htmlspecialchars($nomeDaTurma) . " EXCLUÍDA COM SUCESSO!!!";
                } else {
                    $_SESSION['erros_turma'] = ["Erro ao excluir a turma."];
                }
            }
            // Após a tentativa de exclusão, sempre redireciona para a lista de turmas.
            header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
            exit;
        }
    }
}

// --- ROTEAMENTO DE AÇÕES ---
// Este é um roteador muito simples. Ele verifica se um parâmetro 'action' foi passado na URL
// (ex: .../TurmaController.php?action=salvar).
if (isset($_GET['action'])) {
    // Cria uma instância do controller.
    $controller = new TurmaController();
    // Usa um switch para chamar o método correspondente à ação solicitada.
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