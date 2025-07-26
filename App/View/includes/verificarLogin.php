<?php
session_start();

require_once __DIR__ . '/../../Config/Database.php';
require_once __DIR__ . '/../../Model/UsuarioModel.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Chamada correta para o método existente
$pdo = Database::conectar();

$usuarioModel = new UsuarioModel($pdo);
$usuario = $usuarioModel->validarLogin($email, $senha);

if ($usuario) {
    $_SESSION['usuario'] = $usuario;

    if (in_array($usuario['perfil'], ['adm', 'professor'])) {
        header('Location: home.php');
    } else {
        header('Location: pages/home.php');
    }
    exit;
} else {
    $_SESSION['erro_login'] = 'Email ou senha inválidos';
    header('Location: ../adm/login.php');
    exit;
}

