<?php

require_once __DIR__ . "/BaseModel.php";

class AlunoModel extends BaseModel{
    public $listaAlunos; 

    function buscarAlunos(){

        $sql = "SELECT 
                p.nome AS nome_pessoa, 
                t.nome AS nome_turma
            FROM aluno_turma at
            INNER JOIN pessoa p
                ON at.pessoa_id = p.pessoa_id
            INNER JOIN turma t
                ON at.turma_id = t.turma_id;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
}