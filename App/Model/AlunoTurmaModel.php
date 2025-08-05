<?php

require_once __DIR__ . "/BaseModel.php";

class AlunoTurmaModel extends BaseModel 
{
    public function __construct()
    {
        $this->tabela = "turma";
        parent::__construct();
    }

    public function lista()
    {
        $query = "SELECT * FROM $this->tabela";

        $stmt = $this->pdo->prepare($query);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}