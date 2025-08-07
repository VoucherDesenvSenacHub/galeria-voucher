<?php
namespace App\Model;

use App\Config\Database;

class BaseModel {

    protected $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

}