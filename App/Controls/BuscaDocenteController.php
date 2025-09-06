<?php 

require_once __DIR__ . '/../Model/DocenteModel.php';


$termo = isset($_GET['busca']) ? strtolower($_GET['busca']) : "";

$docenteModel = new DocenteModel();
$dados = $docenteModel->PesquisarDocente($termo);


header("Content-Type: application/json");
echo json_encode($dados, JSON_UNESCAPED_UNICODE);