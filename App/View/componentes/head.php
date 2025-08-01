<?php 
require_once __DIR__ . '/../../Config/env.php';
require_once __DIR__ . '/input.php';
require_once __DIR__ . '/button.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<link rel="stylesheet" href="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_CSS"] ?>globals.css">
<link rel="stylesheet" href="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_CSS"] ?>adm/modal-cadastro.css">

<!-- Script para controle da barra de pesquisa -->
<script src="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_JS"] ?>searchControl.js"></script>

<!-- Script para controle do menu hambúrguer -->
<script src="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_JS"] ?>users/nav.js"></script>

<?php
function headerComponent($titulo){
    echo "
    <title>$titulo</title>
    ";
}
    ?>
</head>