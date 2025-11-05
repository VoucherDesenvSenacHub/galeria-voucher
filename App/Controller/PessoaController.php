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

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$linkedin = $_POST['linkedin'] ?? '';
$github = $_POST['github'] ?? '';
$perfil = $_POST['perfil'] ?? null;
$turmaId = isset($_POST['turma_id']) && is_numeric($_POST['turma_id']) ? (int)$_POST['turma_id'] : null;

switch ($acao) {
    case 'cadastrar':
        if (empty($nome) || empty($email) || empty($perfil)) {
            Redirect::toAdm('cadastrar-usuarios.php', ['erro' => 'Preencha todos os campos obrigatórios (nome, e-mail e perfil).']);
            exit;
        }

        if (empty($_FILES['imagem']) || $_FILES['imagem']['error'] !== UPLOAD_ERR_OK) {
            $params = [
                'erro' => 'É obrigatório enviar uma imagem de perfil.',
                'nome' => $nome,
                'email' => $email,
                'linkedin' => $linkedin,
                'github' => $github,
                'perfil' => $perfil,
                'acao' => 'cadastrar'
            ];
            Redirect::toAdm('cadastrar-usuarios.php', $params);
            exit;
        }

        // Se chegou aqui, é porque o upload foi feito corretamente
        $resultadoUpload = $uploadService->salvar($_FILES['imagem'], 'perfil');

        if ($resultadoUpload['success']) {
            $imagemModel = new ImagemModel();
            $imagemId = $imagemModel->criarImagem($resultadoUpload['caminho'], null, 'Imagem de perfil');
        } else {
            Redirect::toAdm('cadastrar-usuarios.php', [
                'erro' => $resultadoUpload['erro'],
                'nome' => $nome,
                'email' => $email,
                'linkedin' => $linkedin,
                'github' => $github,
                'perfil' => $perfil,
                'acao' => 'cadastrar'
            ]);
            exit;
        }

        $dados = ['nome' => $nome, 'email' => $email, 'perfil' => $perfil, 'linkedin' => $linkedin, 'github' => $github];
        if ($model->criarPessoa($dados, $imagemId)) {
            Redirect::toAdm('listarUsuarios.php');
        } else {
            $msg = $model->getUltimoErro() ?: 'Erro ao cadastrar pessoa.';
            Redirect::toAdm('cadastrar-usuarios.php', ['erro' => $msg]);
        }
        break;

    case 'editar':
        if (empty($nome) || empty($email) || empty($perfil)) {
            Redirect::toAdm('cadastrar-usuarios.php', ['erro' => 'Preencha todos os campos obrigatórios (nome, e-mail e perfil).']);
            exit;
        }

        $imagemId = null;
        if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $resultadoUpload = $uploadService->salvar($_FILES['imagem'], 'perfil');
            if ($resultadoUpload['success']) {
                $imagemModel = new ImagemModel();
                $imagemId = $imagemModel->criarImagem($resultadoUpload['caminho'], null, 'Imagem de perfil');
            } else {
                Redirect::toAdm('cadastrar-usuarios.php', ['acao' => 'editar', 'id' => $id, 'erro' => $resultadoUpload['erro']]);
            }
        }

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'perfil' => $perfil,
            'linkedin' => $linkedin,
            'github' => $github
        ];

        if ($model->atualizarPessoa((int)$id, $dados, $imagemId)) {
            Redirect::toAdm('listarUsuarios.php');
        } else {
            $msg = 'Erro ao cadastrar pessoa.';
            Redirect::toAdm('cadastrar-usuarios.php', ['erro' => $msg]);
        }
        break;

    case 'excluir':
        if ($id && $perfil) {
            if ($model->deletarPessoa((int)$id, $perfil)) {
                Redirect::toAdm('listarUsuarios.php');
            } else {
                $msg = 'Erro: Não foi possível excluir o registro.';
                Redirect::toAdm('listarUsuarios.php', ['erro' => $msg]);
            }
        } else {
            $msg = 'Erro: ID ou perfil não especificado.';
            Redirect::toAdm('listarUsuarios.php', ['erro' => $msg]);
        }
        break;
}




    // case 'excluir':
    //     if ($id && isset($_GET['perfil'])) {
    //         if ($model->deletarPessoa($id, $_GET['perfil'])) {
    //             Redirect::toAdm('listarUsuarios.php');
    //         } else {
    //             $msg = 'Erro: Não foi possível excluir o registro.';
    //             Redirect::toAdm('listarUsuarios.php', ['erro' => $msg]);
    //         }
    //     } else {
    //         $msg = 'Erro: ID ou perfil não especificado.';
    //         Redirect::toAdm('listarUsuarios.php', ['erro' => $msg]);
    //     }
    //     break;