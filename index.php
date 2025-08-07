<?php
require_once __DIR__ . '/App/Config/env.php';
require_once __DIR__ . '/app/Model/AlunoTurmaModel.php';

$alunoTurmaModel = new AlunoTurmaModel();
$alunos = $alunoTurmaModel->Turma146();

// Para ver todos os alunos
echo "<h3>Todos os alunos da Turma 146:</h3>";
print_r($alunos);

echo "<hr>";

// Para acessar o primeiro aluno
if (!empty($alunos)) {
    echo "<h3>Primeiro aluno:</h3>";
    print_r($alunos[0]);
    
    echo "<h3>GitHub do primeiro aluno:</h3>";
    echo $alunos[0]["github"];
    
    echo "<hr>";
    
    // Para iterar sobre todos os alunos
    echo "<h3>GitHub de todos os alunos:</h3>";
    foreach ($alunos as $aluno) {
        echo "Nome: " . $aluno['nome'] . " - GitHub: " . $aluno['github'] . "<br>";
    }
} else {
    echo "Nenhum aluno encontrado na Turma 146.";
}
