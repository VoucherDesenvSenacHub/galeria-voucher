<?php 

namespace App\Model;

use PDO;
use App\Config\Database;

class EstatisticasModel {
    private $conn;
    private $table_name = 'estatisticas';
    
    /** contrutor da classe.
     * obtém conexão com o banco usando singleton
     */
    public function __construct()
    {
        //pega a instância da conexão e armazena no objeto
        $this->conn = Database::getInstance()->getConnection();
    }

    /**busca os dados de estatisticas da tabela.
     * como só tem uma linha (id=1), vai sempre buscar por ela
     * @return array|false retorna um array com os dados ou false se não encotrar
     */
    public function getEstatisticas()
    {
        $query = "SELECT alunos, projetos, polos, horas
                  FROM " . $this->table_name . "
                  WHERE id = 1";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetch(); //fetch() já possui FETCH_ASSOC na config em Database.php
    }

    /**
     * atualiza os dados de estatisticas no banco
     * @param int $alunos
     * @param int $projetos
     * @param int $polos
     * @param int $horas
     * @return bool retorna true se a atualização foi bem sucedida, false caso contrário
     */
    public function updateEstatisticas($alunos, $projetos, $polos, $horas)
    {
        $query = "UPDATE" . $this-> table_name . " SET
                    alunos = :alunos,
                    projetos = :projetos,
                    polos = :polos,
                    horas = :horas
                  WHERE id = 1";

        try {
            $stmt = $this->conn->prepare($query);

            //vincula os valores aos placeholders de forma segura
            $stmt->bindParam(':alunos', $alunos, PDO::PARAM_INT);
            $stmt->bindParam(':projetos', $projetos, PDO::PARAM_INT);
            $stmt->bindParam(':polos', $polos, PDO::PARAM_INT);
            $stmt->bindParam(':horas', $horas, PDO::PARAM_INT);

            //executa a query e retorna o resultado
            return $stmt->execute();
        } catch (\PDOException $e) {
            //se der erro, loga a mensagem pra depuração
            error_log("Erro ao atualizar estatísticas: " . $e->getMessage());
            return false;
        }
    }
}
?>