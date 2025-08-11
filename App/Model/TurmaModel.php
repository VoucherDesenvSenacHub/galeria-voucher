<?php

require_once __DIR__ . '/BaseModel.php';

class TurmaModel extends BaseModel
{
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
     * @param string $data_inicio A data de início da turma (formato YYYY-MM-DD).
     * @param string|null $data_fim A data de término da turma (formato YYYY-MM-DD).
     * @param int $polo_id O ID do polo ao qual a turma pertence.
     * @param int|null $imagem_id O ID da imagem associada à turma.
     * @return int|false O ID da turma inserida em caso de sucesso, ou false em caso de falha.
     */
    public function criarTurma(string $nome, ?string $descricao, string $data_inicio, ?string $data_fim, int $polo_id, ?int $imagem_id = null)
    {
        try {
            $query = "
                INSERT INTO " . $this->tabela . " 
                (nome, descricao, data_inicio, data_fim, polo_id, imagem_id) 
                VALUES (:nome, :descricao, :data_inicio, :data_fim, :polo_id, :imagem_id)
            ";

            $stmt = $this->pdo->prepare($query);

            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':descricao', $descricao, PDO::PARAM_STR);
            $stmt->bindParam(':data_inicio', $data_inicio, PDO::PARAM_STR);
            $stmt->bindParam(':data_fim', $data_fim, PDO::PARAM_STR);
            $stmt->bindParam(':polo_id', $polo_id, PDO::PARAM_INT);
            $stmt->bindParam(':imagem_id', $imagem_id, PDO::PARAM_INT);

            $stmt->execute();
            
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
        try {
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
            return []; // Retorna um array vazio em caso de erro
        }
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
     * Busca os dados de uma turma específica pelo ID.
     * @param int $id O ID da turma.
     * @return array|false
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
     *Atualiza os dados de uma turma.
     */
    public function atualizarTurma(int $turma_id, string $nome, ?string $descricao, string $data_inicio, ?string $data_fim, int $polo_id, ?int $imagem_id)
    {
        try {
            $query = "UPDATE turma SET 
                        nome = :nome, 
                        descricao = :descricao, 
                        data_inicio = :data_inicio, 
                        data_fim = :data_fim, 
                        polo_id = :polo_id,
                        imagem_id = :imagem_id
                      WHERE turma_id = :turma_id";
            $stmt = $this->pdo->prepare($query);
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
     *Exclui uma turma.
     */
    public function excluirTurma(int $id): bool
    {
        try {
            // Exclui dependências antes para evitar erros de chave estrangeira
            $this->pdo->beginTransaction();
            $stmt1 = $this->pdo->prepare("DELETE FROM aluno_turma WHERE turma_id = :id");
            $stmt1->execute([':id' => $id]);
            $stmt2 = $this->pdo->prepare("DELETE FROM docente_turma WHERE turma_id = :id");
            $stmt2->execute([':id' => $id]);
            $stmt3 = $this->pdo->prepare("DELETE FROM projeto WHERE turma_id = :id");
            $stmt3->execute([':id' => $id]);
            
            $stmtFinal = $this->pdo->prepare("DELETE FROM turma WHERE turma_id = :id");
            $stmtFinal->execute([':id' => $id]);
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            error_log("Erro ao excluir turma: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Busca o URL de uma imagem pelo seu ID.
     * @param int $imagem_id O ID da imagem.
     * @return string|null O URL da imagem ou null se não for encontrada.
     */
    public function buscarUrlDaImagem(int $imagem_id): ?string
    {
        try {
            $stmt = $this->pdo->prepare("SELECT url FROM imagem WHERE imagem_id = :id");
            $stmt->execute([':id' => $imagem_id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['url'] : null;
        } catch (PDOException $e) {
            error_log("Erro ao buscar URL da imagem: " . $e->getMessage());
            return null;
        }
    }


}
