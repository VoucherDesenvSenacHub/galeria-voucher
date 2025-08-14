<?php

$acao = $_GET['acao'] ?? $_POST['acao'] ?? '';

$nomeAluno =  $_Get['nome'] ?? $_POST['nome'] ?? '';
$nomeTurma =  $_Get['turma'] ?? $_POST['turma'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    switch ($acao) {
        case 'carregarTurma': {
                
            }
    }
}
