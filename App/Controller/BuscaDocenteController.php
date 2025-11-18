<?php 
require_once __DIR__ . '/../Helpers/Request.php';
require_once __DIR__ . '/../Model/DocenteModel.php';


$termo = isset($_GET['busca']) ? strtolower($_GET['busca']) : "";
$turmaId = Request::getId('turma_id');

$docenteModel = new DocenteModel();
$dados = $docenteModel->buscarDocentesParaVincular($termo, $turmaId);


header("Content-Type: application/json");
echo json_encode($dados, JSON_UNESCAPED_UNICODE);
