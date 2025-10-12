<?php 
// Inicia a sessão antes de qualquer output
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

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

<link rel="stylesheet" href="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_CSS"] ?>easter_egg.css">

<!-- Script para controle do menu hambúrguer -->
<script src="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_JS"] ?>users/nav.js"></script>
<script src="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_JS"] ?>global.js"></script>

<?php
function headerComponent($titulo){
    echo "
    <title>$titulo</title>
    ";
}
    ?>
</head>