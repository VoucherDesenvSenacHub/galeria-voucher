<?php

require_once 'App/Model/TurmasImageModel.php'; 

$imagensModel = new ImagensModel();
$imagens = $imagensModel->buscarTodas();

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File Upload</title>

</head>

<body>
    <section>
        <div class="flex end">
            <a href="usuarioCadastrar.php">
                Cadastrar usuário
            </a>
        </div>
        <form action="App\View\pages\users\turma.php"
            method="POST"
            enctype="multipart/form-data">
            <input type="file" name="foto" accept="image/*">
            <button type="submit">Enviar</button>
        </form>
    </section>

    <section>
        <div class="container">
            <?php foreach ($imagens as $imagem): ?>
                <div class="image-box">
                    <img src="<?= $imagem['descricao
                    '] ?>">
                </div>
            <?php endforeach  ?>
        </div>
    </section>
</body>

</html>