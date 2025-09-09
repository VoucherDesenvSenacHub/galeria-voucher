<?php
require_once __DIR__ . '/../../../Controller/UsuarioController.php';

$usuarioController = new UsuarioController();

// Verifica se está logado
$usuarioController->verificarLogin();

// Dados do usuário
$usuarioNome   = $usuarioController->getUsuarioNome();
$usuarioImagem = $usuarioController->getUsuarioImagem();
