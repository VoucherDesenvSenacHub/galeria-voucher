<?php

require_once __DIR__ . '/BaseModel.php';

class PoloModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Busca um polo pelo nome e retorna seus dados.
     * @param string $nome O nome do polo.
     * @return array|false
     */
    public function buscarPorNome(string $nome)
    {
        try {
            $query = "SELECT polo_id FROM polo WHERE nome = :nome LIMIT 1";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([':nome' => $nome]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar polo por nome: " . $e->getMessage());
            return false;
        }
    }

    /**
     * MÉTODO ADICIONADO: Busca todos os polos para preencher um select box.
     * @return array
     */
    public function buscarTodos(): array
    {
        try {
            $query = "SELECT polo_id, nome FROM polo ORDER BY nome ASC";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar todos os polos: " . $e->getMessage());
            return [];
        }
    }
}