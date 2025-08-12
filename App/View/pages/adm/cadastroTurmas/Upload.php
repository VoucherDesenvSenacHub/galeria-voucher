<?php
if (isset($_POST["acao"])) { 
    $arquivo = $_FILES["turma"]; 
    $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));

    // Valida extensão
    if (!in_array($extensao, ['jpeg', 'png', 'jpg'])) {
        die("Apenas JPEG, JPG ou PNG são permitidos.");
    }

    // Nome aleatório
    $novoNome = uniqid('', true) . '.' . $extensao;
    $destino = __DIR__ . '/../../../../../Upload/' . $novoNome;

    // Move o arquivo
    if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
        echo "Arquivo enviado com sucesso!<br>";

        // ID da turma vindo do formulário
        $idTurma = intval($_POST['id_turma']);

        // Salva no banco
        $stmt = $pdo->prepare("UPDATE turmas SET imagem = :imagem WHERE id = :id");
        $stmt->bindParam(':imagem', $novoNome);
        $stmt->bindParam(':id', $idTurma);
        $stmt->execute();
    }

}
?>

<!DOCTYPE html>
<html lang="pt-br"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="turma" accept="image/jpeg,image/png,image/jpg">
        <input type="submit" name="acao" value="Enviar">
    </form>
</body>
</html>