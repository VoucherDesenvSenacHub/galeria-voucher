<?php
require_once __DIR__ . '/../Model/PessoaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';
require_once __DIR__ . '/../Service/ImagensUploadService.php'; // Incluído o novo serviço

$model = new PessoaModel();
$uploadService = new ImagensUploadService();

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';
$id = $_GET['id'] ?? $_POST['id'] ?? null;

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$linkedin = $_POST['linkedin'] ?? '';
$github = $_POST['github'] ?? '';
$perfil = $_GET['perfil'] ?? $_POST['perfil'] ?? null;
$turmaId = isset($_POST['turma_id']) && is_numeric($_POST['turma_id']) ? (int)$_POST['turma_id'] : null;

switch ($acao) {
    case 'cadastrar':
        $erros = [];
        if (empty($nome)) { $erros[] = 'nome'; }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $erros[] = 'e-mail'; }
        if (empty($perfil)) { $erros[] = 'perfil'; }

        if (!empty($erros)) {
            $msg = 'Erro no cadastro (' . implode(', ', $erros) . ')';
            header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?erro=" . urlencode($msg));
            exit;
        }

        // Upload da imagem (opcional). Se não enviar, o model usará imagem padrão
        $imagemId = null;
        if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $resultadoUpload = $uploadService->salvar($_FILES['imagem'], 'perfil');

            if ($resultadoUpload['success']) {
                $imagemModel = new ImagemModel();
                $imagemId = $imagemModel->criarImagem($resultadoUpload['caminho'], null, 'Imagem de perfil');
            } else {
                header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?erro=" . urlencode($resultadoUpload['erro']));
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

        if ($model->criarPessoa($dados, $imagemId)) {
            header("Location: /galeria-voucher/App/View/pages/adm/listarUsuarios.php");
            exit;
        } else {
            $msg = $model->getUltimoErro() ?: 'Erro ao cadastrar pessoa.';
            header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?erro=" . urlencode($msg));
            exit;
        }
    case 'editar':
        if (!$id) break;

        $dados = [
            'nome' => $nome,
            'email' => $email,
            'perfil' => $perfil,
            'linkedin' => $linkedin,
            'github' => $github
        ];

        // Validação
        $erros = [];
        if (empty($dados['nome'])) { $erros[] = 'nome'; }
        if (empty($dados['email']) || !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) { $erros[] = 'e-mail'; }
        if (empty($dados['perfil'])) { $erros[] = 'perfil'; }

        if (!empty($erros)) {
            $msg = 'Erro na edição (' . implode(', ', $erros) . ')';
            header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?acao=editar&id={$id}&erro=" . urlencode($msg));
            exit;
        }

        // Upload de nova imagem
        $imagemId = null;
        if (!empty($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            $resultadoUpload = $uploadService->salvar($_FILES['imagem'], 'perfil');

            if ($resultadoUpload['success']) {
                $imagemModel = new ImagemModel();
                $imagemId = $imagemModel->criarImagem($resultadoUpload['caminho'], null, 'Imagem de perfil');
            } else {
                header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?acao=editar&id={$id}&erro=" . urlencode($resultadoUpload['erro']));
                exit;
            }
        }

        // Atualiza a pessoa (passa $imagemId apenas se houver upload)
        $ok = $model->atualizarPessoa((int)$id, $dados, $imagemId);

        if ($ok) {
            // Atualiza vínculo conforme perfil
            if ($perfil === 'aluno' && $turmaId !== null) {
                $model->atualizarVinculoAluno((int)$id, $turmaId);
            } elseif ($perfil === 'professor' && $turmaId !== null) {
                $model->atualizarVinculoDocente((int)$id, $turmaId);
            }
            header("Location: /galeria-voucher/App/View/pages/adm/listarUsuarios.php");
            exit;
        } else {
            $msg = 'Erro ao atualizar pessoa.';
            header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?acao=editar&id={$id}&erro=" . urlencode($msg));
            exit;
        }


    case 'excluir':
        if ($id && $perfil) {
            if ($model->deletarPessoa($id, $perfil)) {
                header("Location: /galeria-voucher/App/View/pages/adm/listarUsuarios.php");
                exit;
            } else {
                $detalhe = $model->getUltimoErro() ?: 'Existem vínculos.';
                $msg = 'Erro: Não foi possível excluir o registro. ' . $detalhe;
                header("Location: /galeria-voucher/App/View/pages/adm/listarUsuarios.php?erro=" . urlencode($msg));
                exit;
            }
        } else {
            $msg = 'Erro: ID do usuário não especificado.';
            header("Location: /galeria-voucher/App/View/pages/adm/listarUsuarios.php?erro=" . urlencode($msg));
            exit;
        }
}