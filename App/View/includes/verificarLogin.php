<?php
session_start();

require_once __DIR__ . '/../../Config/App.php'; // Usa App.php
require_once __DIR__ . '/../../Config/Database.php';
require_once __DIR__ . '/../../Model/UsuarioModel.php';

$email = $_POST['email'] ?? '';
$senha = $_POST['senha'] ?? '';

// Chamada correta para o método existente
$pdo = Database::conectar();

$usuarioModel = new UsuarioModel($pdo);
$usuario = $usuarioModel->validarLogin($email, $senha);

// Redirecionamentos no final:
if ($usuario) {
    $_SESSION['usuario'] = $usuario;
    if (in_array($usuario['perfil'], ['adm', 'professor'])) {
        header('Location: ' . Config::getDirAdm() . 'home-adm.php');
    } else {
        header('Location: ' . Config::getDirUser() . 'home.php');
    }
    exit;
} else {
    $_SESSION['erro_login'] = 'Email ou senha inválidos';
    header('Location: ' . Config::getDirAdm() . 'login.php');
    exit;
}

