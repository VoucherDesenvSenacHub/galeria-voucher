<?php
require_once __DIR__ . '/../../../model/UsuarioModel.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['usuario'])) {
    header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'login.php');
    exit;
}

// Variáveis de usuário seguras para usar no home
$usuarioNome = htmlspecialchars($_SESSION['usuario']['nome'] ?? '');

$model = new UsuarioModel();

// Buscar só imagem
$usuarioImagem = $model->buscarImagemPorPessoaId($_SESSION['usuario']['pessoa_id']);
