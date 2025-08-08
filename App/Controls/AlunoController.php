<?php
require_once __DIR__ . '/../Model/AlunoModel.php';

$acao = $_GET['acao'] ?? '';

if ($acao == 'alunos') {
    $model = new AlunoModel();
    $alunos = $model->buscarAlunos();

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($alunos, JSON_UNESCAPED_UNICODE);
    exit; // Garante que nada mais é enviado
}
