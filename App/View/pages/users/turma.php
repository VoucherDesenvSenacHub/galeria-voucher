<?php

require_once __DIR__ . '/../../../Model/TurmasImageModel.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES['foto'])) {
        $imagem = $_FILES['foto'];

        $imagemSalva = ImagensModel::upload($imagem);
    }
}


?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>
</head>
<body>
    <?php if ($imagemSalva): ?>
        <p>
            Imagem salva com sucesso em <?= $imagemSalva['descricao'] ?>.
            <a href="index.php">Voltar</a>
        </p>
    <?php endif ?>
</body>
</html>
