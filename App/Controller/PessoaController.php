<?php
require_once __DIR__ . '/../Model/PessoaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';

$model = new PessoaModel();

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
            $diretorio = __DIR__ . '/../uploads/';
            if (!is_dir($diretorio)) { mkdir($diretorio, 0777, true); }
            $nomeArquivo = uniqid() . '_' . basename($_FILES['imagem']['name']);
            $caminhoCompleto = $diretorio . $nomeArquivo;
            $urlPublica = 'uploads/' . $nomeArquivo;

            $tipoImagem = strtolower(pathinfo($caminhoCompleto, PATHINFO_EXTENSION));
            $permitidos = ['jpg', 'jpeg', 'png', 'gif'];
            $verificaImagem = getimagesize($_FILES['imagem']['tmp_name']);
            if ($verificaImagem === false || !in_array($tipoImagem, $permitidos)) {
                $msg = 'Erro no cadastro (foto)';
                header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?erro=" . urlencode($msg));
                exit;
            }

            if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
                $msg = 'Erro no cadastro (falha no upload da foto)';
                header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?erro=" . urlencode($msg));
                exit;
            }

            $imagemModel = new ImagemModel();
            $imagemId = $imagemModel->criarImagem($urlPublica, null, 'Imagem de perfil');
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

            $erros = [];
            if (empty($dados['nome'])) { $erros[] = 'nome'; }
            if (empty($dados['email']) || !filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) { $erros[] = 'e-mail'; }
            if (empty($dados['perfil'])) { $erros[] = 'perfil'; }

            if (!empty($erros)) {
                $msg = 'Erro no cadastro (' . implode(', ', $erros) . ')';
                header("Location: /galeria-voucher/App/View/pages/adm/cadastrar-usuarios.php?acao=editar&id={$id}&erro=" . urlencode($msg));
                exit;
            }

            $ok = $model->atualizarPessoa((int)$id, $dados, null);
            if ($ok) {
                // Atualiza vinculo conforme perfil (opcional se turma_id for enviado)
                if ($perfil === 'aluno') {
                    // Atualiza vínculo do aluno se turma_id vier
                    if ($turmaId !== null) { $model->atualizarVinculoAluno((int)$id, $turmaId); }
                } elseif ($perfil === 'professor') {
                    if ($turmaId !== null) { $model->atualizarVinculoDocente((int)$id, $turmaId); }
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

        // ... (resto do código)
}
