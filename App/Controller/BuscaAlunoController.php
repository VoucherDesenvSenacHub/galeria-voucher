<?php 
require_once __DIR__ . '/../Model/AlunoModel.php';

$termo = isset($_GET['busca']) ? strtolower($_GET['busca']) : "";

$AlunoModel = new AlunoModel();
$dados = $AlunoModel->buscarAlunosParaVincular($termo);

header("Content-Type: application/json");
echo json_encode($dados, JSON_UNESCAPED_UNICODE);