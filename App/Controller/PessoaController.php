<?php
require_once __DIR__ . '/../Config/Config.php';
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
$senha = trim($_POST['senha'] ?? '');
$linkedin = trim($_POST['linkedin'] ?? '');
$github = trim($_POST['github'] ?? '');
$perfil = $_POST['perfil'] ?? null;
$turmaId = isset($_POST['turma_id']) && is_numeric($_POST['turma_id']) ? (int)$_POST['turma_id'] : null;

switch ($acao) {
    case 'cadastrar':
        if (empty($nome) || empty($email) || empty($perfil)) {
            Redirect::toAdm('cadastroUsuarios.php', [
                'erro' => 'Preencha todos os campos obrigatórios (nome, e-mail e perfil).',
                'acao' => $acao,
                'id' => $id
            ]);
        }
        
        $imagemId = null;
        if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $resultadoUpload = $uploadService->salvarArquivo($_FILES['imagem'], 'perfil');
            if ($resultadoUpload['success']) {
                $imagemModel = new ImagemModel();
                $imagemId = $imagemModel->criarImagem($resultadoUpload['caminho'], null, 'Imagem de perfil');
            } else {
                Redirect::toAdm('cadastroUsuarios.php', ['erro' => $resultadoUpload['erro']]);
            }
        }

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'senha' => $senha,
            'perfil' => $perfil,
            'linkedin' => $linkedin,
            'github' => $github
        ];

        if ($model->criarPessoa($dados, $imagemId)) {
            Redirect::toAdm('usuarios.php');
        } else {
            $msg = $model->getUltimoErro() ?: 'Erro ao cadastrar pessoa.';
            Redirect::toAdm('cadastroUsuarios.php', ['erro' => $msg]);
        }
        break;

    case 'editar':
        if (empty($nome) || empty($email) || empty($perfil)) {
            Redirect::toAdm('cadastroUsuarios.php', [
                'erro' => 'Preencha todos os campos obrigatórios (nome, e-mail e perfil).',
                'acao' => $acao,
                'id' => $id
            ]);
        }

        $imagemId = null;
        if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $resultadoUpload = $uploadService->salvarArquivo($_FILES['imagem'], 'perfil');
            if ($resultadoUpload['success']) {
                $imagemModel = new ImagemModel();
                $imagemId = $imagemModel->criarImagem($resultadoUpload['caminho'], null, 'Imagem de perfil');
            } else {
                Redirect::toAdm('cadastroUsuarios.php', [
                    'acao' => $acao,
                    'id' => $id,
                    'erro' => $resultadoUpload['erro']
                ]);
            }
        }

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'perfil' => $perfil,
            'linkedin' => $linkedin,
            'github' => $github
        ];

        if (empty($id)) {
            Redirect::toAdm('usuarios.php', ['erro' => 'ID não informado para edição.']);
            exit;
        }
        $sucesso = $model->atualizarPessoa((int)$id, $dados, $imagemId);

        if ($sucesso) {
            Redirect::toAdm('usuarios.php');
        } else {
            Redirect::toAdm('cadastroUsuarios.php', [
                'erro' => 'Erro ao atualizar pessoa.',
                'acao' => $acao,
                'id' => $id
            ]);
        }
        break;

    case 'excluir':
        if (empty($id)) {
            Redirect::toAdm('usuarios.php', ['erro' => 'ID não informado para exclusão.']);
            exit;
        }

        if ($model->deletarPessoa((int)$id)) {
            Redirect::toAdm('usuarios.php');
        } else {
            Redirect::toAdm('usuarios.php', ['erro' => 'Erro: Não foi possível excluir o registro.']);
        }
        break;

    default:
        Redirect::toAdm('usuarios.php', ['erro' => 'Ação inválida.']);
        break;
}
