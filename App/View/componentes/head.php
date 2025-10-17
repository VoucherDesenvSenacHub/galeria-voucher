<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../../Config/App.php'; // Usa App.php
require_once __DIR__ . '/input.php';
require_once __DIR__ . '/button.php';

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="<?= Config::get('APP_URL') . Config::get('DIR_CSS') ?>globals.css">
<link rel="stylesheet" href="<?= Config::get('APP_URL') . Config::get('DIR_CSS') ?>adm/modal-cadastro.css">

<script src="<?= Config::get('APP_URL') . Config::get('DIR_JS') ?>users/nav.js"></script>
<script src="<?= Config::get('APP_URL') . Config::get('DIR_JS') ?>global.js"></script>

<link rel="stylesheet" href="<?= Config::get('APP_URL') . Config::get('DIR_CSS') ?>easter_egg.css">

<?php
function headerComponent($titulo){
    echo "<title>$titulo</title>";
}
?>
</head>