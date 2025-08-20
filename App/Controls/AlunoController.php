<?php
require_once __DIR__ . '/../Model/AlunoModel.php';

$acao = $_GET['acao'] ?? '';

if($_SERVER["REQUEST_METHOD"] == "GET"){
    switch($acao){
        case 'alunos':
            $model = new AlunoModel();
            $alunos = $model->buscarAlunos();
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($alunos, JSON_UNESCAPED_UNICODE);
            break; // Garante que nada mais é enviado
        case 'alunoSemTurma':
            $model = new AlunoModel();
            $alunos = $model->buscarAlunosSemTurma();
            
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($alunos, JSON_UNESCAPED_UNICODE);
            break; // Garante que nada mais é enviado
        default:
            http_response_code(404);
            echo json_encode(['erro'], JSON_UNESCAPED_UNICODE);
    }
}