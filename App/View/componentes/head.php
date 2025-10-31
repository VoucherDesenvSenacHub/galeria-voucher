<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../Config/App.php'; // Usa App.php
require_once __DIR__ . '/../../Helpers/Request.php';
require_once __DIR__ . '/input.php';
require_once __DIR__ . '/button.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?= Config::getDirCss() ?>globals.css">
<link rel="stylesheet" href="<?= Config::getDirCss() ?>adm/modal-cadastro.css">

<script src="<?= Config::getDirJs() ?>users/nav.js"></script>
<script src="<?= Config::getDirJs() ?>global.js"></script>

<link rel="stylesheet" href="<?= Config::getDirCss() ?>easter_egg.css">

<?php
function headerComponent($titulo){
    echo "<title>$titulo</title>";
}
?>
</head>