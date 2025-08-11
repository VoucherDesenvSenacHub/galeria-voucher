<?php

// Requer o BaseModel para a conexão com o banco.
require_once __DIR__ . '/BaseModel.php';

/**
 * Classe TurmaModel
 * Centraliza toda a lógica de banco de dados para a entidade 'turma'.
 */
class TurmaModel extends BaseModel
{
    // Define o nome da tabela principal para esta classe, facilitando a reutilização em queries.
    public function __construct()
    {
        $this->tabela = "turma";
        parent::__construct();
    }

    /**
     * Cria uma nova turma no banco de dados.
     *
     * @param string $nome O nome da turma.
     * @param string|null $descricao A descrição da turma.
     * @param string $data_inicio A data de início (formato YYYY-MM-DD).
     * @param string|null $data_fim A data de término (formato YYYY-MM-DD).
     * @param int $polo_id O ID do polo associado.
     * @param int|null $imagem_id O ID da imagem de capa (opcional).
     * @return int|false O ID da nova turma inserida, ou false em caso de falha.
     */
    public function criarTurma(string $nome, ?string $descricao, string $data_inicio, ?string $data_fim, int $polo_id, ?int $imagem_id = null)
    {
        try {
            // Query de inserção usando o nome da tabela definido no construtor.
            $query = "
                INSERT INTO " . $this->tabela . " 
                (nome, descricao, data_inicio, data_fim, polo_id, imagem_id) 
                VALUES (:nome, :descricao, :data_inicio, :data_fim, :polo_id, :imagem_id)
            ";

            $stmt = $this->pdo->prepare($query);

            // bindParam associa uma variável a um placeholder. É útil para especificar o tipo de dado (ex: PDO::PARAM_INT).
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':data_inicio', $data_inicio, PDO::PARAM_STR);
            $stmt->bindParam(':data_fim', $data_fim, PDO::PARAM_STR);
            $stmt->bindParam(':polo_id', $polo_id, PDO::PARAM_INT);
            $stmt->bindParam(':imagem_id', $imagem_id, PDO::PARAM_INT);

            $stmt->execute();
            
            // Retorna o ID do último registro inserido.
            return $this->pdo->lastInsertId();

        } catch (PDOException $e) {
            error_log("Erro ao criar turma: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca todas as turmas com o nome do respectivo polo.
     * Útil para listagens administrativas onde se precisa saber a qual polo a turma pertence.
     * @return array Um array de turmas, cada uma com seu ID, nome e o nome do polo.
     */
    public function buscarTodasTurmasComPolo(): array
    {
        try {
            // A cláusula JOIN combina linhas da tabela 'turma' (alias 't') com a tabela 'polo' (alias 'p')
            // onde a condição t.polo_id = p.polo_id é verdadeira.
            // AS é usado para renomear as colunas no resultado, evitando conflito de nomes (ambas têm 'nome').
            $query = "
                SELECT 
                    t.turma_id,
                    t.nome AS NOME_TURMA,
                    p.nome AS NOME_POLO
                FROM " . $this->tabela . " t
                JOIN polo p ON t.polo_id = p.polo_id
                ORDER BY t.nome ASC
            ";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            error_log("Erro ao buscar turmas com polo: " . $e->getMessage());
            return []; // Retorna array vazio para consistência.
        }
    }

    /**
     * Busca turmas para exibição em uma galeria pública.
     * Seleciona os dados essenciais para mostrar um card de turma (nome e imagem).
     * @return array Um array de turmas com id, nome e a URL da imagem.
     */
    public function buscarTurmasParaGaleria(): array
    {
        // LEFT JOIN é usado aqui para garantir que TODAS as turmas sejam retornadas,
        // mesmo aquelas que não possuem uma imagem associada (nesse caso, imagem_url será NULL).
        $query = "
            SELECT 
                t.turma_id,
                t.nome AS nome_turma,
                i.url AS imagem_url
            FROM turma t
            LEFT JOIN imagem i ON t.imagem_id = i.imagem_id
            ORDER BY t.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca os dados de uma única turma pelo seu ID.
     * @param int $id O ID da turma.
     * @return array|false Um array associativo com todos os dados da turma, ou false se não for encontrada.
     */
    public function buscarPorId(int $id)
    {
        try {
            $stmt = $this->pdo->prepare("SELECT * FROM turma WHERE turma_id = :id");
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Erro ao buscar turma por ID: " . $e->getMessage());
            return false;
        }
    }

     /**
     * Atualiza os dados de uma turma existente no banco.
     * @return bool Retorna `true` em caso de sucesso e `false` em caso de falha.
     */
    public function atualizarTurma(int $turma_id, string $nome, ?string $descricao, string $data_inicio, ?string $data_fim, int $polo_id, ?int $imagem_id)
    {
        try {
            // Query SQL de atualização.
            $query = "UPDATE turma SET 
                        nome = :nome, 
                        descricao = :descricao, 
                        data_inicio = :data_inicio, 
                        data_fim = :data_fim, 
                        polo_id = :polo_id,
                        imagem_id = :imagem_id
                      WHERE turma_id = :turma_id";
            $stmt = $this->pdo->prepare($query);
            // execute() pode receber um array associativo e retorna true/false, indicando o sucesso da operação.
            return $stmt->execute([
                ':turma_id' => $turma_id,
                ':nome' => $nome,
                ':descricao' => $descricao,
                ':data_inicio' => $data_inicio,
                ':data_fim' => $data_fim,
                ':polo_id' => $polo_id,
                ':imagem_id' => $imagem_id
            ]);
        } catch (PDOException $e) {
            error_log("Erro ao atualizar turma: " . $e->getMessage());
            return false;
        }
    }

     /**
     * Exclui uma turma e todos os seus registros dependentes.
     * Usa uma transação para garantir a integridade dos dados.
     * @param int $id O ID da turma a ser excluída.
     * @return bool Retorna `true` se tudo foi excluído com sucesso, `false` caso contrário.
     */
    public function excluirTurma(int $id): bool
    {
        try {
            // Inicia uma transação. Todas as queries a seguir devem ser bem-sucedidas.
            // Se qualquer uma falhar, todas as anteriores são desfeitas (rollback).
            $this->pdo->beginTransaction();

            // 1. Exclui as associações de alunos com esta turma.
            $stmt1 = $this->pdo->prepare("DELETE FROM aluno_turma WHERE turma_id = :id");
            $stmt1->execute([':id' => $id]);

            // 2. Exclui as associações de docentes com esta turma.
            $stmt2 = $this->pdo->prepare("DELETE FROM docente_turma WHERE turma_id = :id");
            $stmt2->execute([':id' => $id]);

            // 3. Exclui os projetos associados a esta turma.
            $stmt3 = $this->pdo->prepare("DELETE FROM projeto WHERE turma_id = :id");
            $stmt3->execute([':id' => $id]);
            
            // 4. Finalmente, exclui a própria turma.
            $stmtFinal = $this->pdo->prepare("DELETE FROM turma WHERE turma_id = :id");
            $stmtFinal->execute([':id' => $id]);

            // Se todas as queries foram executadas com sucesso, confirma as alterações no banco.
            $this->pdo->commit();
            return true;

        } catch (PDOException $e) {
            // Se qualquer query falhar, desfaz todas as operações feitas desde o beginTransaction().
            $this->pdo->rollBack();
            error_log("Erro ao excluir turma: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca a URL de uma imagem pelo seu ID.
     * (Nota: Este método poderia pertencer logicamente à ImagemModel, mas está aqui para conveniência).
     * @param int $imagem_id O ID da imagem.
     * @return string|null O URL da imagem ou null se não for encontrada.
     */
    public function buscarUrlDaImagem(int $imagem_id): ?string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT url FROM imagem WHERE imagem_id = :id");
            $stmt->execute([':id' => $imagem_id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            // Operador ternário: se $resultado for verdadeiro (encontrou), retorna $resultado['url'], senão retorna null.
            return $resultado ? $resultado['url'] : null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar URL da imagem: " . $e->getMessage());
            return null;
        }
    }
}