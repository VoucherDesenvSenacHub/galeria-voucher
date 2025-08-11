<?php

// Requer o arquivo BaseModel para herdar a conexão com o banco.
require_once __DIR__ . '/BaseModel.php';

/**
 * Classe PoloModel
 * Responsável pelas operações de banco de dados da tabela 'polo'.
 */
class PoloModel extends BaseModel
{
    /**
     * Construtor da classe.
     * Chama o construtor pai para estabelecer a conexão com o banco.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Busca um polo específico pelo seu nome.
     * @param string $nome O nome exato do polo a ser buscado.
     * @return array|false Retorna um array associativo com o 'polo_id' se encontrado, ou `false` em caso de erro ou se não for encontrado.
     */
    public function buscarPorNome(string $nome)
    {
        try {
            // Query para selecionar o ID de um polo com base no nome.
            // LIMIT 1 otimiza a busca, parando assim que encontrar o primeiro resultado.
            $query = "SELECT polo_id FROM polo WHERE nome = :nome LIMIT 1";
            
            // Prepara a query para execução segura.
            $stmt = $this->pdo->prepare($query);
            
            // Associa o parâmetro :nome com a variável $nome e executa.
            $stmt->execute([':nome' => $nome]);
            
            // Retorna o resultado como um array associativo.
            return $stmt->fetch(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Registra qualquer erro de banco de dados no log do servidor.
            error_log("Erro ao buscar polo por nome: " . $e->getMessage());
            // Retorna false para sinalizar a falha.
            return false;
        }
    }

    /**
     * Busca todos os polos cadastrados no banco de dados.
     * Ideal para preencher um campo <select> em um formulário.
     * @return array Retorna um array de arrays associativos (cada um contendo 'polo_id' e 'nome'), ou um array vazio em caso de erro.
     */
    public function buscarTodos(): array
    {
        try {
            // Query para selecionar o ID e o nome de todos os polos, ordenados alfabeticamente.
            $query = "SELECT polo_id, nome FROM polo ORDER BY nome ASC";
            
            // Prepara a query.
            $stmt = $this->pdo->prepare($query);
            
            // Executa a query.
            $stmt->execute();
            
            // Retorna todos os resultados encontrados como um array de arrays associativos.
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            // Em caso de erro, registra no log.
            error_log("Erro ao buscar todos os polos: " . $e->getMessage());
            // Retorna um array vazio para evitar que a aplicação quebre onde este método for chamado.
            return [];
        }
    }
}