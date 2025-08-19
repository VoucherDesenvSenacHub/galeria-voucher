<?php

require_once __DIR__ . "/BaseModel.php";

class TurmaModel extends BaseModel
{

    public function __construct()
    {
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
     * Busca todas as turmas com o nome do respectivo polo, ordenadas alfabeticamente.
     * @return array
     */
    public function buscarTodasTurmasComPolo(): array
    {
        $query = "
            SELECT 
                t.turma_id,
                t.nome AS NOME_TURMA,
                p.nome AS NOME_POLO
            FROM 
                turma t
            JOIN 
                polo p ON t.polo_id = p.polo_id
            ORDER BY 
                t.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca turmas por nome ou polo.
     * @param string $termo O termo para buscar.
     * @return array
     */
    public function buscarTurmasPorNomeOuPolo(string $termo): array
    {
        $query = "
            SELECT 
                t.turma_id,
                t.nome AS NOME_TURMA,
                p.nome AS NOME_POLO
            FROM 
                turma t
            JOIN 
                polo p ON t.polo_id = p.polo_id
            WHERE 
                t.nome LIKE :termo OR p.nome LIKE :termo
            ORDER BY 
                t.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':termo' => '%' . $termo . '%']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Busca todas as turmas ativas com suas respectivas imagens de capa.
     * @return array
     */
    public function buscarTurmasParaGaleria(): array
    {
        // Esta query junta a tabela 'turma' com a 'imagem' para buscar a URL da imagem de cada turma.
        // Se quiser adicionar um IS NOT NULL para garantir que apenas turmas com imagem sejam exibidas. WHERE t.imagem_id IS NOT NULL 
        $query = "
            SELECT 
                t.turma_id,
                t.nome AS nome_turma,
                COALESCE(i.url, 'App/View/assets/img/utilitarios/foto.png') AS imagem_url
            FROM turma t
            LEFT JOIN imagem i ON t.imagem_id = i.imagem_id
            ORDER BY t.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca os dados de uma turma específica pelo ID.
     * @param int $id O ID da turma.
     * @return array|false
     */
    public function buscarTurmaPorId(int $id)
    {
        $query = "SELECT * FROM turma WHERE turma_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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
