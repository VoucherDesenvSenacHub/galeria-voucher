<?php

require_once __DIR__ . "/BaseModel.php";

class PessoaModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca todas as pessoas com seus respectivos polos e perfis.
     * @return array
     */
    public function buscarTodasPessoasComPolo(): array
    {
        $query = "
            SELECT
                p.pessoa_id,
                p.nome,
                p.perfil AS tipo,
                COALESCE(polo_aluno.nome, polo_docente.nome, 'N/A') AS polo
            FROM
                pessoa p
            LEFT JOIN (
                SELECT at.pessoa_id, po.nome
                FROM aluno_turma at
                JOIN turma t ON at.turma_id = t.turma_id
                JOIN polo po ON t.polo_id = po.polo_id
                GROUP BY at.pessoa_id, po.nome
            ) AS polo_aluno ON p.pessoa_id = polo_aluno.pessoa_id
            LEFT JOIN (
                SELECT dt.pessoa_id, po.nome
                FROM docente_turma dt
                JOIN turma t ON dt.turma_id = t.turma_id
                JOIN polo po ON t.polo_id = po.polo_id
                GROUP BY dt.pessoa_id, po.nome
            ) AS polo_docente ON p.pessoa_id = polo_docente.pessoa_id
            ORDER BY
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // crud  criado conferir e testar!
    // Criar pessoa (Create)

    public function criarPessoa(array $dados, ?int $imagemId = null): bool
    {
        // Se não foi passada uma imagem, usa a padrão
        if ($imagemId === null) {
            $imagemModel = new ImagemModel($this->pdo);
            $imagemPadrao = $imagemModel->buscarImagemPorUrl('App/View/assets/img/utilitarios/avatar.png');

            if ($imagemPadrao) {
                $imagemId = (int)$imagemPadrao['imagem_id'];
            } else {
                // Se a imagem padrão não existe, cria ela
                $imagemId = $imagemModel->criarImagem(
                    'App/View/assets/img/utilitarios/avatar.png',
                    'Imagem padrão de perfil',
                    'Avatar padrão para usuários sem foto'
                );
            }
        }

        $sql = "INSERT INTO pessoa (nome, email, perfil, linkedin, github, imagem_id) 
                VALUES (:nome, :email, :perfil, :linkedin, :github, :imagem_id)";

        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute([
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':perfil' => $dados['perfil'],
            ':linkedin' => $dados['linkedin'] ?? null,
            ':github' => $dados['github'] ?? null,
            ':imagem_id' => $imagemId
        ]);
    }

    // Buscar pessoa por ID (Read)
    public function buscarPessoaPorId(int $id): ?array
    {
        $sql = "SELECT * FROM pessoa WHERE pessoa_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

        return $resultado ?: null;
    }

    // Atualizar pessoa (Update)
    public function atualizarPessoa(int $id, array $dados, ?int $imagemId = null): bool
    {
        $sql = "UPDATE pessoa SET nome = :nome, email = :email, perfil = :perfil, linkedin = :linkedin, github = :github";

        if ($imagemId !== null) {
            $sql .= ", imagem_id = :imagem_id";
        }

        $sql .= " WHERE pessoa_id = :id";

        $stmt = $this->pdo->prepare($sql);

        $params = [
            ':nome' => $dados['nome'],
            ':email' => $dados['email'],
            ':perfil' => $dados['perfil'],
            ':linkedin' => $dados['linkedin'] ?? null,
            ':github' => $dados['github'] ?? null,
            ':id' => $id
        ];

        if ($imagemId !== null) {
            $params[':imagem_id'] = $imagemId;
        }

        return $stmt->execute($params);
    }

    // Deletar pessoa (Delete)
    public function deletarPessoa(int $id): bool
    {
        $sql = "DELETE FROM pessoa WHERE pessoa_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // Listar todas as pessoas
    public function listarPessoas(): array
    {
        $sql = "SELECT * FROM pessoa";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    // Funcao para listamos 
    public function listarPerfisPermitidos(): array
    {
        $sql = "SHOW COLUMNS FROM pessoa WHERE Field = 'perfil'";
        $stmt = $this->pdo->query($sql);
        $coluna = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$coluna) return [];

        preg_match("/^enum\((.*)\)$/", $coluna['Type'], $matches);

        if (!isset($matches[1])) return [];

        $valores = explode(',', $matches[1]);
        $valores = array_map(function ($valor) {
            return trim($valor, " '");
        }, $valores);

        return $valores;
    }

    /**
     * Lista todas as pessoas com seus respectivos polos.
     * @return array
     */
    public function listarPessoasComPolo(): array
    {
        $query = "
            SELECT
                p.pessoa_id,
                p.nome,
                p.perfil AS tipo,
                polo.nome AS polo
            FROM
                pessoa p
            LEFT JOIN
                aluno_turma at ON p.pessoa_id = at.pessoa_id
            LEFT JOIN
                docente_turma dt ON p.pessoa_id = dt.pessoa_id
            LEFT JOIN
                turma t ON at.turma_id = t.turma_id OR dt.turma_id = t.turma_id
            LEFT JOIN
                polo ON t.polo_id = polo.polo_id
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
     * Busca pessoas por nome ou polo.
     * @param string $termo O termo para buscar.
     * @return array
     */
    public function buscarPessoasPorNomeOuPolo(string $termo): array
    {
        $query = "
            SELECT
                p.pessoa_id,
                p.nome,
                p.perfil AS tipo,
                polo.nome AS polo
            FROM
                pessoa p
            LEFT JOIN
                aluno_turma at ON p.pessoa_id = at.pessoa_id
            LEFT JOIN
                docente_turma dt ON p.pessoa_id = dt.pessoa_id
            LEFT JOIN
                turma t ON at.turma_id = t.turma_id OR dt.turma_id = t.turma_id
            LEFT JOIN
                polo ON t.polo_id = polo.polo_id
            WHERE
                p.nome LIKE :termo OR polo.nome LIKE :termo
            GROUP BY
                p.pessoa_id
            ORDER BY
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':termo' => '%' . $termo . '%']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Conta o total de pessoas, opcionalmente filtrando por um termo de busca.
     * @param string $termo O termo para filtrar a contagem.
     * @return int O número total de pessoas.
     */
    public function contarTotalPessoas(string $termo = ''): int
    {
        $query = "SELECT COUNT(DISTINCT p.pessoa_id) 
                  FROM pessoa p
                  LEFT JOIN aluno_turma at ON p.pessoa_id = at.pessoa_id
                  LEFT JOIN docente_turma dt ON p.pessoa_id = dt.pessoa_id
                  LEFT JOIN turma t ON at.turma_id = t.turma_id OR dt.turma_id = t.turma_id
                  LEFT JOIN polo ON t.polo_id = polo.polo_id";
        
        $params = [];
        if (!empty($termo)) {
            $query .= " WHERE p.nome LIKE :termo OR polo.nome LIKE :termo";
            $params[':termo'] = '%' . $termo . '%';
        }

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return (int)$stmt->fetchColumn();
    }

    /**
     * Busca pessoas com paginação e filtro.
     * @param int $limite O número de registros por página.
     * @param int $offset O deslocamento (a partir de qual registro buscar).
     * @param string $termo O termo de busca.
     * @return array A lista de pessoas da página.
     */
    public function buscarPessoasPaginado(int $limite, int $offset, string $termo = ''): array
    {
        $query = "
            SELECT 
                p.pessoa_id,
                p.nome,
                p.perfil AS tipo,
                polo.nome AS polo
            FROM 
                pessoa p
            LEFT JOIN
                aluno_turma at ON p.pessoa_id = at.pessoa_id
            LEFT JOIN
                docente_turma dt ON p.pessoa_id = dt.pessoa_id
            LEFT JOIN
                turma t ON at.turma_id = t.turma_id OR dt.turma_id = t.turma_id
            LEFT JOIN
                polo ON t.polo_id = polo.polo_id
        ";
        
        $params = [];
        if (!empty($termo)) {
            $query .= " WHERE p.nome LIKE :termo OR polo.nome LIKE :termo";
            $params[':termo'] = '%' . $termo . '%';
        }

        $query .= " GROUP BY p.pessoa_id ORDER BY p.nome ASC LIMIT :limite OFFSET :offset";

        $stmt = $this->pdo->prepare($query);

        if (!empty($termo)) {
            $stmt->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}








