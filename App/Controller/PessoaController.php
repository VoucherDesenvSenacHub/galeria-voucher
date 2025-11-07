<?php
require_once __DIR__ . '/../Config/App.php';
require_once __DIR__ . '/../Helpers/Redirect.php';
require_once __DIR__ . '/../Model/PessoaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';
require_once __DIR__ . '/../Service/ImagensUploadService.php';

$model = new PessoaModel();
$uploadService = new ImagensUploadService();

$acao = $_POST['acao'] ?? $_GET['acao'] ?? '';
$id = $_POST['id'] ?? $_GET['id'] ?? null;

$nome = trim($_POST['nome'] ?? '');
$email = trim($_POST['email'] ?? '');
$linkedin = trim($_POST['linkedin'] ?? '');
$github = trim($_POST['github'] ?? '');
$perfil = $_POST['perfil'] ?? null;
$turmaId = isset($_POST['turma_id']) && is_numeric($_POST['turma_id']) ? (int)$_POST['turma_id'] : null;

switch ($acao) {
    case 'cadastrar':
    case 'editar':
        if (empty($nome) || empty($email) || empty($perfil)) {
            Redirect::toAdm('cadastrar-usuarios.php', [
                'erro' => 'Preencha todos os campos obrigatórios (nome, e-mail e perfil).',
                'acao' => $acao,
                'id' => $id
            ]);
            exit;
        }

        $imagemId = null;
        if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $resultadoUpload = $uploadService->salvar($_FILES['imagem'], 'perfil');
            if ($resultadoUpload['success']) {
                $imagemModel = new ImagemModel();
                $imagemId = $imagemModel->criarImagem($resultadoUpload['caminho'], null, 'Imagem de perfil');
            } else {
                Redirect::toAdm('cadastrar-usuarios.php', [
                    'acao' => $acao,
                    'id' => $id,
                    'erro' => $resultadoUpload['erro']
                ]);
                exit;
            }
        }

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'perfil' => $perfil,
            'linkedin' => $linkedin,
            'github' => $github
        ];

        if ($acao === 'cadastrar') {
            $sucesso = $model->criarPessoa($dados, $imagemId);
            $mensagemErro = $model->getUltimoErro() ?: 'Erro ao cadastrar pessoa.';
        } else {
            if (empty($id)) {
                Redirect::toAdm('listarUsuarios.php', ['erro' => 'ID não informado para edição.']);
                exit;
            }
            $sucesso = $model->atualizarPessoa((int)$id, $dados, $imagemId);
            $mensagemErro = 'Erro ao atualizar pessoa.';
        }

        if ($sucesso) {
            Redirect::toAdm('listarUsuarios.php');
        } else {
            Redirect::toAdm('cadastrar-usuarios.php', [
                'erro' => $mensagemErro,
                'acao' => $acao,
                'id' => $id
            ]);
        }
        break;

    case 'excluir':
        if (empty($id)) {
            Redirect::toAdm('listarUsuarios.php', ['erro' => 'ID não informado para exclusão.']);
            exit;
        }

        if ($model->deletarPessoa((int)$id)) {
            Redirect::toAdm('listarUsuarios.php');
        } else {
            Redirect::toAdm('listarUsuarios.php', ['erro' => 'Erro: Não foi possível excluir o registro.']);
        }
        break;

    default:
        Redirect::toAdm('listarUsuarios.php', ['erro' => 'Ação inválida.']);
        break;
}
