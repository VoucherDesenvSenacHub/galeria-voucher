<?php

require_once __DIR__ . "/BaseModel.php";

class AlunoTurmaModel extends BaseModel 
{
    public function __construct()
    {
        $this->tabela = "turma";
        parent::__construct();
    }

    public function Turma146()
    {
        $query = "SELECT p.email, p.nome, p.linkedin, p.github, p.perfil
                  FROM pessoa p
                  LEFT JOIN aluno_turma at ON p.pessoa_id = at.pessoa_id
                  LEFT JOIN turma t ON at.turma_id = t.turma_id where exibir_pagina_dev = 1;";

        $stmt = $this->pdo->prepare($query);
        
        $stmt->execute([":"]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}