<?php 

namespace App\Config;

use PDO;
use PDOException;

class Database
{
    //credenciais banco
    private $host = '127.0.0.1';
    private $db_name = 'galeria_voucher';
    private $username = 'root';
    private $password = '';

    private static $instance = null;
    private $conn;

    /**
     * construtor privado pra evitar criação de novas instâncias
     */
    private function __construct()
    {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name . ';charset=utf8mb4';

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password);
            //configura o PDO pra lançar exceções em caso de erro
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //garante que os dados sejam retornados como array associativo de padrão
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            //em caso de erro na conexão, loga o erro e encerra a aplicação
            error_log('Erro de conexão: ' . $e->getMessage());
            die('Erro ao conectar ao banco de dados. Verifique as credenciais no arquivo.');
        }
    }

    /**
     * método estático que controla o acesso à instância
     * @return Database
     */
    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance;
    }

    /**
     * retorna o objeto de conexão PDO
     */
    public function getConnection()
    {
        return $this->conn;
    }

    //impede que a instância seja clonada
    private function __clone(){}

    //impede que a instância seja recriada a partir de uma string
    public function __wakeup(){}
    
}

?>