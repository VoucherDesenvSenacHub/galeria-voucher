<?php
if (isset($_POST["acao"])) { // Corrigido: "aco" para "acao" (nome correto do input submit)
    echo "Enviado...";
    $arquivo = $_FILES["turma"]; // Corrigido: nome da variável singular para consistência

    // Obtém a extensão do arquivo
    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    
    // Verifica se a extensão é válida
    if (!in_array(strtolower($extensao), ['jpeg', 'png', 'jpg'])) {
        die("Você não pode fazer o upload desse arquivo. Apenas JPEG, JPG ou PNG são permitidos.");
    } else {
        echo "Enviando turma...";
        // Corrigido: caminho do arquivo e uso correto da variável
        $destino = '../../../img' . $arquivo['name'];
        if (move_uploaded_file($arquivo['tmp_name'], $destino)) {
            echo "Arquivo enviado com sucesso!";
        } else {
            echo "Erro ao enviar o arquivo.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br"> <!-- Corrigido: idioma para pt-br, mais apropriado para o contexto -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Imagem</title> <!-- Corrigido: título mais descritivo -->
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="file" name="turma" accept="image/jpeg,image/png,image/jpg"> <!-- Adicionado: accept para limitar tipos de arquivo -->
        <input type="submit" name="acao" value="Enviar">
    </form>
</body>
</html>