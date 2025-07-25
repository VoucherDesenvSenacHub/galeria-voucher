<?php

class Database
{

    static function connect()
    {
        $host = 'localhost';
        $port = '3306';
        $username = 'root';
        $password = '';
        $database = 'galeria_voucher';

        $conectionUrl = "mysql:host=$host;port=$port;dbname=$database;charset=utf8mb4";

        return new \PDO($conectionUrl, $username, $password);
    }

}