<?php

require_once __DIR__ . "/BaseModel.php";

class EstatisticasModel extends BaseModel {

    private $numAlunos;
    private $numProjetos;
    private $numPolos;

    public function __construct() {
        parent::__construct();
    }

    public function getEstatisticas() {

        // Conta alunos
        $query1 = "SELECT COUNT(*) FROM pessoa where perfil = 'aluno'";
        $stmt1 = $this->pdo->prepare($query1);
        $stmt1->execute();
        $this->numAlunos = $stmt1->fetchColumn();

        // Conta projetos
        $query2 = "SELECT COUNT(*) FROM projeto";
        $stmt2 = $this->pdo->prepare($query2);
        $stmt2->execute();
        $this->numProjetos = $stmt2->fetchColumn();

        // Conta polos
        $query3 = "SELECT COUNT(*) FROM polo";
        $stmt3 = $this->pdo->prepare($query3);
        $stmt3->execute();
        $this->numPolos = $stmt3->fetchColumn();

        return [
            'alunos' => $this->numAlunos,
            'projetos' => $this->numProjetos,
            'polos' => $this->numPolos
        ];
    }
}