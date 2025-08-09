<?php
require_once __DIR__ . '/../Model/PessoaModel.php';

$model = new PessoaModel();

$acao = $_POST['acao'] ?? '';
$id = $_POST['id'] ?? null;

$nome = $_POST['nome'] ?? '';
$email = $_POST['email'] ?? '';
$linkedin = $_POST['linkedin'] ?? '';
$github = $_POST['github'] ?? '';
$perfil = $_POST['perfil'] ?? '';
$polo = $_POST['polo'] ?? '';
$imagem = $_FILES['imagem'] ?? null;

var_dump($acao, $id);