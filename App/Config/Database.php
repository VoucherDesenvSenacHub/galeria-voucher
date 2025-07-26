<?php

class Database {
    public static function conectar(): PDO {
        $host = 'localhost';
        $port = '3306';
        $dbname = 'galeriavoucher';
        $user = 'root';
        $pass = '';

        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            die("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }
}
