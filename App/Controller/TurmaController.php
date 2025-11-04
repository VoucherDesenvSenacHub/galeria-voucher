<?php
session_start();

// Inclui os novos helpers e a configuração
require_once __DIR__ . '/../Config/App.php';
require_once __DIR__ . '/../Helpers/Request.php';
require_once __DIR__ . '/../Helpers/Redirect.php';

require_once __DIR__ . '/../Model/TurmaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';
require_once __DIR__ . '/../Service/ImagensUploadService.php';

class TurmaController {
    
    private $uploadService;

    public function __construct()
    {
        $this->uploadService = new ImagensUploadService();
    }
    
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
        if (Request::getMethod() === 'POST') {
            
            $nome = trim(Request::post('nome', ''));
            $descricao = trim(Request::post('descricao', ''));
            $data_inicio = Request::post('data_inicio', '');
            $data_fim = !empty(Request::post('data_fim')) ? Request::post('data_fim') : null;
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

            $imagemFile = Request::file('imagem_turma');
            if ($imagemFile && $imagemFile['error'] === UPLOAD_ERR_OK) {
                $resultadoUpload = $this->uploadService->salvar($imagemFile, 'turma');

                if ($resultadoUpload['success']) {
                    $imagemModel = new ImagemModel();
                    $imagem_id = $imagemModel->salvarImagem($resultadoUpload['caminho'], "Imagem da turma " . $nome);
                } else {
                    $erros[] = $resultadoUpload['erro'];
                }
            }
            
            
            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                Redirect::toAdm('cadastro-turmas/cadastro-turmas.php');
                return;
            }

            $turmaModel = new TurmaModel();
            $resultado = $turmaModel->criarTurma($nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($resultado) {
                $_SESSION['sucesso_cadastro'] = "" . $nome . " CADASTRADA COM SUCESSO !!!";
                Redirect::toAdm('cadastro-turmas/cadastro-turmas.php', ['id' => $resultado]);
            } else {
                $_SESSION['erros_turma'] = ["Ocorreu um erro ao salvar a turma."];
                Redirect::toAdm('cadastro-turmas/cadastro-turmas.php');
            }
        }
    }

    public function atualizar() {
        if (Request::getMethod() === 'POST') {
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            if (!$turma_id) {
                Redirect::toAdm('listaTurmas.php');
                return;
            }

            $turmaModel = new TurmaModel();
            
            $dadosAntigos = $turmaModel->buscarTurmaPorId($turma_id);
            if (!$dadosAntigos) {
                $_SESSION['erros_turma'] = ["Turma não encontrada para atualização."];
                Redirect::toAdm('listaTurmas.php');
                return;
            }

            $nome = trim(Request::post('nome', ''));
            $descricao = trim(Request::post('descricao', ''));
            $data_inicio = Request::post('data_inicio', '');
            $data_fim = !empty(Request::post('data_fim')) ? Request::post('data_fim') : null;
            $polo_id = filter_input(INPUT_POST, 'polo_id', FILTER_VALIDATE_INT);
            $imagem_id = filter_input(INPUT_POST, 'imagem_id_atual', FILTER_VALIDATE_INT) ?: null;

            $erros = [];
            if (empty($nome)) { $erros[] = "O campo 'Nome' é obrigatório."; }
            if (empty($data_inicio)) { $erros[] = "O campo 'Início' é obrigatório."; }
            if ($polo_id === false || $polo_id <= 0) { $erros[] = "É obrigatório selecionar um 'Polo'."; }
                
            if (!empty($data_inicio) && !empty($data_fim)) {
                try {
                    $inicioObj = new DateTime($data_inicio);
                    $fimObj = new DateTime($data_fim);
                    if ($fimObj < $inicioObj) {
                        $erros[] = "A data de término não pode ser anterior à data de início.";
                    }
                } catch (Exception $e) {
                    $erros[] = "Formato de data inválido.";
                }
            }

            $imagemFile = Request::file('imagem_turma');
            if ($imagemFile && $imagemFile['error'] === UPLOAD_ERR_OK) {
                $resultadoUpload = $this->uploadService->salvar($imagemFile, 'turma');

                if ($resultadoUpload['success']) {
                    $imagemModel = new ImagemModel();
                    $novo_imagem_id = $imagemModel->salvarImagem($resultadoUpload['caminho'], "Imagem atualizada da turma " . $nome);
                    if ($novo_imagem_id) {
                        $imagem_id = $novo_imagem_id; 
                    }
                } else {
                    $erros[] = $resultadoUpload['erro'];
                }
            }
        
            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                Redirect::toAdm("cadastro-turmas/cadastro-turmas.php", ['id' => $turma_id]);
                return;
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
                $mensagem = "" . $nome . " ATUALIZADA COM SUCESSO!!!";
                
                if (!empty($camposAlterados)) {
                    $mensagem .= " Campos alterados: " . implode(', ', $camposAlterados) . ".";
                } else {
                    $mensagem .= " Nenhuma alteração foi Feita.";
                }
                $_SESSION['sucesso_edicao_alert'] = $mensagem;

            } else {
                $_SESSION['erros_turma'] = ["Erro ao atualizar a turma."];
            }
            Redirect::toAdm("cadastro-turmas/cadastro-turmas.php", ['id' => $turma_id]);
        }
    }

    public function excluir() {
        if (Request::getMethod() === 'POST') {
            $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);
            if ($turma_id) {
                $turmaModel = new TurmaModel();

                $turma = $turmaModel->buscarTurmaPorId($turma_id);
                $nomeDaTurma = $turma ? $turma['nome'] : '';

                if ($turmaModel->excluirTurma($turma_id)) {
                    $_SESSION['sucesso_exclusao'] = "" . $nomeDaTurma . " EXCLUÍDA COM SUCESSO!!!";
                } else {
                    $_SESSION['erros_turma'] = ["Erro ao excluir a turma."];
                }
            }
            Redirect::toAdm('listaTurmas.php');
        }
    }
}


$action = Request::get('action');
if ($action) {
    $controller = new TurmaController();
    switch ($action) {
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