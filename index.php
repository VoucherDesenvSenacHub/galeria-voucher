<?php
require_once __DIR__ . '/App/Config/env.php';
require_once __DIR__ . '/app/Model/AlunoTurmaModel.php';

$alunoTurma = new AlunoTurmaModel();



var_dump($alunoTurma->Turma146());
