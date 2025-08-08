<?php
require_once __DIR__ . '/../Model/PessoaModel.php';

$model = new PessoaModel();
$mensagem = 'criado';
$pessoaCriada = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    var_dump($_POST);
    $dados = [
        'nome' => $_POST['nome'] ?? '',
        'email' => $_POST['email'] ?? '',
        'perfil' => $_POST['perfil'] ?? '',
        'linkedin' => $_POST['linkedin'] ?? '',
        'github' => $_POST['github'] ?? ''
    ];


    $criado = $model->criarPessoa($dados, null); // sem imagem por enquanto

    // if ($criado) {
        
    //     $pessoaCriada = $model->buscarPessoaPorId($ultimoId);
    //     $mensagem = "✅ Pessoa criada com sucesso! ID: {$ultimoId}";
    // } else {
    //     $mensagem = "❌ Erro ao cadastrar pessoa.";
    // }




    $perfis = $model->listarPerfisPermitidos();

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
        <?php echo 'SALVOU'; ?> 
    <?php endif; ?>
    <?php 
    $perfis = $model->listarPerfisPermitidos();
    ?>

    <form method="POST">
        <label>Nome:</label><br>
        <input type="text" name="nome" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Perfil:</label><br>
        <select name="perfil" required>
            <option value="">-- Selecione --</option>
            <?php foreach ($perfis as $perfil): ?>
                <option value="<?= $perfil ?>"><?= ucfirst($perfil) ?></option>
            <?php endforeach; ?>
        </select>


        <label>LinkedIn:</label><br>
        <input type="text" name="linkedin"><br><br>

        <label>GitHub:</label><br>
        <input type="text" name="github"><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>

</html>