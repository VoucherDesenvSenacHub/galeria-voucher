<?php
if (isset($_POST["acao"])) { 
    echo "Enviado...";
    $arquivo = $_FILES["turma"]; 


    $extensao = pathinfo($arquivo['name'], PATHINFO_EXTENSION);
    

    if (!in_array(strtolower($extensao), ['jpeg', 'png', 'jpg'])) {
        die("Você não pode fazer o upload desse arquivo. Apenas JPEG, JPG ou PNG são permitidos.");
    } else {
        echo "Enviando turma...";

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