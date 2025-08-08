
<?php
require_once __DIR__ . '/../Model/PessoaModel.php';

$model = new PessoaModel();
$mensagem = '';
$pessoaCriada = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'nome' => $_POST['nome'] ?? '',
        'email' => $_POST['email'] ?? '',
        'perfil' => $_POST['perfil'] ?? '',
        'linkedin' => $_POST['linkedin'] ?? '',
        'github' => $_POST['github'] ?? ''
    ];

    $criado = $model->criarPessoa($dados, null); // sem imagem por enquanto

    if ($criado) {
        $ultimoId = $model->obterUltimoIdInserido();
        $pessoaCriada = $model->buscarPessoaPorId($ultimoId);
        $mensagem = "✅ Pessoa criada com sucesso! ID: {$ultimoId}";
    } else {
        $mensagem = "❌ Erro ao cadastrar pessoa.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Pessoa</title>
</head>
<body>
    <h1>Cadastro de Pessoa</h1>

    <?php if (!empty($mensagem)): ?>
        <p><?= $mensagem ?></p>
        <?php if ($pessoaCriada): ?>
            <pre><?php print_r($pessoaCriada); ?></pre>
        <?php endif; ?>
    <?php endif; ?>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Perfil:</label><br>
        <select name="perfil" required>
            <option value="aluno">Aluno</option>
            <option value="professor">Professor</option>
        </select><br><br>

        <label>LinkedIn:</label><br>
        <input type="text" name="linkedin"><br><br>

        <label>GitHub:</label><br>
        <input type="text" name="github"><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
