<?php

require_once __DIR__ . '/../Config/Database.php';

class BaseModel {

    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }
    
    public function getLastInsertId(): int {
        return (int)$this->pdo->lastInsertId();
    }

}