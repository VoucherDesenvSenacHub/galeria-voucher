<?php

require_once __DIR__ . '/../Config/Database.php';

class BaseModel {

    protected $pdo;
    protected $tabela; // <--- SEM TIPO AQUI (ou protected string $tabela = ''; se usar PHP >= 7.4 e quiser tipo)

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

    public function getLastInsertId(): int {
        return (int)$this->pdo->lastInsertId();
    }

}