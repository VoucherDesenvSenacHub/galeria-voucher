<?php
class Database
{
    private static $instance = null;
    private PDO $pdo;

    public function __construct()
    {
        $host = 'localhost';
        $port = '3306';
        $dbname = 'galeria_voucher';
        $user = 'root';
        $pass = '';

        try {
            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Erro ao conectar ao banco de dados: " . $e->getMessage());
        }

    }
    public static function conectar(): PDO
    {
        if (self::$instance === null) {
            self::$instance = new Database();
        }

        return self::$instance->pdo;
    }
}
