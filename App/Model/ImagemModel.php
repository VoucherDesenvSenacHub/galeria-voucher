<?php

// Requer o arquivo BaseModel, que provavelmente contém a lógica de conexão com o banco de dados (PDO).
require_once __DIR__ . '/BaseModel.php';

/**
 * Classe ImagemModel
 * Responsável por todas as operações de banco de dados relacionadas à tabela 'imagem'.
 */
class ImagemModel extends BaseModel
{
    /**
     * Construtor da classe.
     * Chama o construtor da classe pai (BaseModel) para inicializar a conexão com o banco.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Salva os dados de uma imagem no banco de dados.
     * Este método insere um novo registro na tabela 'imagem'.
     *
     * @param string $url O caminho relativo do arquivo da imagem que será armazenado.
     * @param string|null $descricao Uma descrição opcional para a imagem.
     * @return int|false Retorna o ID (chave primária) da imagem que acabou de ser inserida em caso de sucesso, ou `false` se ocorrer um erro.
     */
    public function salvarImagem(string $url, ?string $descricao = null)
    {
        try {
            // Query SQL para inserir uma nova imagem.
            // NOW() é uma função do SQL que insere a data e hora atuais.
            $query = "
                INSERT INTO imagem (url, descricao, data_upload) 
                VALUES (:url, :descricao, NOW())
            ";
            
            // Prepara a query para execução, prevenindo injeção de SQL.
            $stmt = $this->pdo->prepare($query);

            // Executa a query, substituindo os placeholders (:url, :descricao) pelos valores reais.
            $stmt->execute([
                ':url' => $url,
                ':descricao' => $descricao
            ]);

            // Retorna o ID do último registro inserido nesta conexão.
            return $this->pdo->lastInsertId();

        } catch (PDOException $e) {
            // Se ocorrer qualquer erro na operação com o banco (ex: tabela não existe, falha de permissão),
            // ele é capturado aqui.
            // A mensagem de erro é registrada no log de erros do servidor para depuração.
            error_log("Erro ao salvar imagem no banco de dados: " . $e->getMessage());
            // Retorna false para indicar que a operação falhou.
            return false;
        }
    }
}