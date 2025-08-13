<?php
require_once __DIR__ . '/../Model/PessoaModel.php';
require_once __DIR__ . '/../Model/ImagemModel.php';

$pessoaModel = new PessoaModel();
$imagemModel = new ImagemModel();
$mensagem = '';
$pessoaCriada = null;



// trim($url) remove espaços do início e fim.

// empty(...) verifica se a string está vazia após o trim.

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Processar upload da imagem
        $imagemId = null;

        if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
            // Validação básica da imagem
            $tipoPermitido = ['image/jpeg', 'image/png', 'image/gif'];
            $tamanhoMaximo = 2 * 1024 * 1024; // 2MB

            if (!in_array($_FILES['imagem']['type'], $tipoPermitido)) {
                throw new Exception("Tipo de arquivo não permitido. Use apenas JPEG, PNG ou GIF.");
            }

            if ($_FILES['imagem']['size'] > $tamanhoMaximo) {
                throw new Exception("Arquivo muito grande. Tamanho máximo: 2MB.");
            }

            // Configurações do upload
            $diretorioUpload = __DIR__ . '/../uploads/';
            $nomeArquivo = uniqid() . '_' . basename($_FILES['imagem']['name']);
            $caminhoCompleto = $diretorioUpload . $nomeArquivo;

            // Criar diretório se não existir
            if (!file_exists($diretorioUpload)) {
                if (!mkdir($diretorioUpload, 0755, true)) {
                    throw new Exception("Não foi possível criar o diretório de uploads.");
                }
            }

            // Mover arquivo
            if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoCompleto)) {
                // Salvar no banco de dados
                $urlRelativa = '/../View/assets/img/uploads/' . $nomeArquivo;
                $imagemId = $imagemModel->criarImagem($urlRelativa, null, 'Imagem de perfil');
            } else {
                throw new Exception("Erro ao mover o arquivo enviado.");
            }
        }

        // Dados da pessoa
        $dados = [
            'nome' => trim($_POST['nome'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'perfil' => $_POST['perfil'] ?? '',
            'linkedin' => trim($_POST['linkedin'] ?? null),
            'github' => trim($_POST['github'] ?? null)
        ];

        // Validações básicas
        if (empty($dados['nome']) || empty($dados['email']) || empty($dados['perfil'])) {
            throw new Exception("Nome, email e perfil são obrigatórios.");
        }

        // Criar pessoa
        $criado = $pessoaModel->criarPessoa($dados, $imagemId);

        if ($criado) {
            $ultimoId = $pessoaModel->getLastInsertId();
            $pessoaCriada = $pessoaModel->buscarPessoaPorId($ultimoId);
            $mensagem = "✅ Pessoa criada com sucesso! ID: {$ultimoId}";
        } else {
            $mensagem = "❌ Erro ao cadastrar pessoa.";
        }
    } catch (Exception $e) {
        $mensagem = "❌ Erro: " . $e->getMessage();
    }
}

$perfis = $pessoaModel->listarPerfisPermitidos();
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pessoa</title>
    <style>
        .success {
            color: green;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Cadastro de Pessoa</h1>

    <?php if (!empty($mensagem)): ?>
        <p class="<?= strpos($mensagem, '✅') !== false ? 'success' : 'error' ?>">
            <?= htmlspecialchars($mensagem) ?>
        </p>
        <?php if ($pessoaCriada): ?>
            <h3>Dados cadastrados:</h3>
            <pre><?php print_r($pessoaCriada); ?></pre>
        <?php endif; ?>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">
        <div>
            <label>Nome:</label><br>
            <input type="text" name="nome" required value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
        </div><br>

        <div>
            <label>Email:</label><br>
            <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div><br>

        <div>
            <label>Perfil:</label><br>
            <select name="perfil" required>
                <option value="">-- Selecione --</option>
                <?php foreach ($perfis as $perfil): ?>
                    <option value="<?= htmlspecialchars($perfil) ?>"
                        <?= ($_POST['perfil'] ?? '') === $perfil ? 'selected' : '' ?>>
                        <?= ucfirst(htmlspecialchars($perfil)) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div><br>

        <div>
            <label>LinkedIn:</label><br>
            <input type="text" name="linkedin" value="<?= htmlspecialchars($_POST['linkedin'] ?? '') ?>">
        </div><br>

        <div>
            <label>GitHub:</label><br>
            <input type="text" name="github" value="<?= htmlspecialchars($_POST['github'] ?? '') ?>">
        </div><br>

        <div>
            <label>Imagem (JPEG, PNG ou GIF - máximo 2MB):</label><br>
            <input type="file" name="imagem" accept="image/jpeg,image/png,image/gif">
        </div><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>

</html>