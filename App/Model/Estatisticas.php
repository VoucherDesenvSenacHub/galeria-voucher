<?php

require_once __DIR__ . "/../Config/Database.php";

class Estatisticas {

    private $numAlunos;
    private $numProjetos;
    private $numPolos;

    public function getEstatisticas() {
        $db = new Database();
        $conn = $db->connect();

        // Conta alunos
        $stmt = $conn->query("SELECT COUNT(*) FROM pessoa where perfil = 'aluno'");
        $this->numAlunos = $stmt->fetchColumn();

        // Conta projetos
        $stmt = $conn->query("SELECT COUNT(*) FROM projeto");
        $this->numProjetos = $stmt->fetchColumn();

        // Conta polos
        $stmt = $conn->query("SELECT COUNT(*) FROM polo");
        $this->numPolos = $stmt->fetchColumn();

        return [
            'alunos' => $this->numAlunos,
            'projetos' => $this->numProjetos,
            'polos' => $this->numPolos
        ];
    }
}

// $estatisticas = new Estatisticas();
// $resultado = $estatisticas->getEstatisticas();
// echo "Alunos: " . $resultado['alunos'] . "<br>";
// echo "Projetos: " . $resultado['projetos'] . "<br>";
// echo "Polos: " . $resultado['polos'] . "<br>";
