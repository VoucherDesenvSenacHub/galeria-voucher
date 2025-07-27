<?php
class Database
{
    public static function conectar(): PDO
    {
        $host = 'localhost';
        $port = '3308';
        $dbname = 'galeriavoucher';
        $user = 'root';
        $pass = '';

        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            // Lança a exceção para ser tratada em outro lugar
            throw new Exception("Erro ao conectar ao banco de dados.");
        }
    }
}
