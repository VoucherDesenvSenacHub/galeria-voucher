<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php');
    exit;
}


// Variáveis de usuário seguras para usar no home
$usuarioNome   = htmlspecialchars($_SESSION['usuario']['nome'] ?? '');
$usuarioImagem = $_SESSION['usuario']['imagem'] ?? VARIAVEIS['APP_URL'] . 'App/View/assets/img/adm/fallbackAdm.png';
