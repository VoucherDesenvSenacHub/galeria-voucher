<?php

require_once __DIR__ . "/BaseModel.php";

class AlunoModel extends BaseModel{
    public $listaAlunos; 
    public function __construct() {
        $this->tabela = "aluno";
        parent::__construct();
    }

    public function buscarAlunos(): array{

        $sql = "SELECT 
        p.nome AS nome_pessoa, 
        t.nome AS nome_turma, 
        t.turma_id AS id_turma
        FROM aluno_turma at
        INNER JOIN pessoa p
            ON at.pessoa_id = p.pessoa_id
        INNER JOIN turma t
            ON at.turma_id = t.turma_id;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }
    public function buscarAlunosSemTurma(){

        $sql = "SELECT p.pessoa_id, p.nome, 'Sem turma' AS status
        FROM pessoa p
        LEFT JOIN aluno_turma at 
            ON p.pessoa_id = at.pessoa_id
        WHERE p.perfil = 'aluno'
          AND at.pessoa_id IS NULL";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();

        $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $dados;
    }

    
    /**
     * Busca todos os alunos com seus respectivos polos.
     * @return array
     */
    public function buscarTodosAlunosComPolo(): array
    {
        $query = "
            SELECT
                p.pessoa_id,
                p.nome,
                polo.nome AS polo
            FROM
                pessoa p
            JOIN
                aluno_turma at ON p.pessoa_id = at.pessoa_id
            JOIN
                turma t ON at.turma_id = t.turma_id
            JOIN
                polo ON t.polo_id = polo.polo_id
            WHERE
                p.perfil = 'aluno'
            GROUP BY
                p.pessoa_id
            ORDER BY
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca todos os alunos de uma turma específica.
     * @param int $turma_id O ID da turma.
     * @return array
     */
    public function buscarAlunosPorTurma(int $turma_id): array
    {
        $query = "
            SELECT
                p.pessoa_id,
                p.nome,
                p.linkedin,
                p.github,
                i.url as imagem_url
            FROM
                pessoa p
            JOIN
                aluno_turma at ON p.pessoa_id = at.pessoa_id
            LEFT JOIN
                imagem i ON p.imagem_id = i.imagem_id
            WHERE
                at.turma_id = :turma_id
                AND p.perfil = 'aluno'
            ORDER BY
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function buscarPorTurma(int $turmaId): array
    {
        $sql = "SELECT p.*, i.url AS foto 
                FROM aluno_turma at
                INNER JOIN pessoa p ON at.pessoa_id = p.pessoa_id
                LEFT JOIN imagem i ON p.imagem_id = i.imagem_id
                WHERE at.turma_id = :turma_id
                ORDER BY p.nome ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

/**
 * Cadastra múltiplos alunos em uma turma, usando um array simples de IDs.
 *
 * @param array $alunosIds Array simples contendo os IDs dos alunos.
 * @param int $turmaId O ID da turma onde os alunos serão inseridos.
 * @return bool Retorna true em caso de sucesso.
 * @throws Exception Em caso de falha.
 */
public function cadastrarAlunosNaTurma(array $alunosIds, int $turmaId) {
    // SQL CORRIGIDO: 3 colunas e 3 placeholders
    $sql = "INSERT INTO aluno_turma (pessoa_id, turma_id, data_matricula) VALUES (:aluno_id, :turma_id, :data_matricula)";

    try {
        // Pega a data e hora atual no formato do MySQL (YYYY-MM-DD HH:MM:SS)
        $dataMatricula = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare($sql);
        $this->pdo->beginTransaction();

        // O loop agora é mais simples
        foreach ($alunosIds as $alunoId) {
            // Associa os parâmetros da query
            $stmt->bindParam(':aluno_id', $alunoId, PDO::PARAM_INT);
            $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT);
            $stmt->bindParam(':data_matricula', $dataMatricula, PDO::PARAM_STR);

            $stmt->execute();
        }

        $this->pdo->commit();
        return true;

    } catch (PDOException $e) {
        $this->pdo->rollBack();
        throw new Exception("Erro ao inserir alunos no banco de dados: " . $e->getMessage());
    }
}

}