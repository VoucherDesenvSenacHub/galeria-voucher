<?php
require_once __DIR__ . '/BaseModel.php';
require_once __DIR__ . '/ImagemModel.php';

class PessoaModel extends BaseModel
{
    private ?string $ultimoErro = null;
    // crud  criado conferir e testar!
    // Criar pessoa (Create)

    public function criarPessoa(array $dados, ?int $imagemId = null): bool
    {
        // Se não foi passada uma imagem, usa a padrão
        if ($imagemId === null) {
            $imagemModel = new ImagemModel();
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

        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([
                ':nome' => $dados['nome'],
                ':email' => $dados['email'],
                ':perfil' => $dados['perfil'],
                ':linkedin' => $dados['linkedin'] ?? null,
                ':github' => $dados['github'] ?? null,
                ':imagem_id' => $imagemId
            ]);
        } catch (PDOException $e) {
            $code = $e->getCode();
            $msg = $e->getMessage();
            // Tratamento amigável para erros comuns
            if ($code === '23000') { // violação de constraint (único/foreign)
                // Chave duplicada (email único)
                if (stripos($msg, 'Duplicate') !== false || stripos($msg, 'UNIQUE') !== false) {
                    $this->ultimoErro = 'E-mail já cadastrado.';
                } else {
                    $this->ultimoErro = 'Violação de restrição no banco.';
                }
            } else {
                $this->ultimoErro = 'Erro no banco: ' . $msg;
            }
            error_log('[PessoaModel::criarPessoa] ' . $this->ultimoErro);
            return false;
        }
    }

    // Buscar pessoa por ID (Read)
    public function buscarPessoaPorId(int $id): ?array
    {

        $sql = "SELECT * FROM pessoa WHERE pessoa_id = :id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado : null;

    }

    /**
     * Busca pessoa com nome do polo associado (se houver, como aluno ou docente).
     */
    public function buscarPessoaComPoloPorId(int $id): ?array
    {
        $sql = "
            SELECT 
                p.*,
                COALESCE(
                    MAX(CASE WHEN poA.nome IS NOT NULL THEN poA.nome END),
                    MAX(CASE WHEN poD.nome IS NOT NULL THEN poD.nome END)
                ) AS nome_polo
            FROM pessoa p
            LEFT JOIN aluno_turma at ON p.pessoa_id = at.pessoa_id
            LEFT JOIN turma tA ON at.turma_id = tA.turma_id
            LEFT JOIN polo poA ON tA.polo_id = poA.polo_id
            LEFT JOIN docente_turma dt ON p.pessoa_id = dt.pessoa_id
            LEFT JOIN turma tD ON dt.turma_id = tD.turma_id
            LEFT JOIN polo poD ON tD.polo_id = poD.polo_id
            WHERE p.pessoa_id = :id
            GROUP BY p.pessoa_id
            LIMIT 1
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultado ? $resultado : null;
    }

    /**
     * Retorna a turma e o polo atualmente vinculados ao usuário, se houver.
     */
    public function buscarTurmaPoloAtual(int $pessoaId): ?array
    {
        // Tenta como aluno primeiro
        $sqlAluno = "SELECT t.turma_id, t.polo_id
                     FROM aluno_turma at
                     JOIN turma t ON at.turma_id = t.turma_id
                     WHERE at.pessoa_id = :id
                     ORDER BY at.aluno_turma_id DESC
                     LIMIT 1";
        $stmt = $this->pdo->prepare($sqlAluno);
        $stmt->execute([':id' => $pessoaId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) { return $row; }

        // Tenta como docente
        $sqlDoc = "SELECT t.turma_id, t.polo_id
                   FROM docente_turma dt
                   JOIN turma t ON dt.turma_id = t.turma_id
                   WHERE dt.pessoa_id = :id
                   ORDER BY dt.docente_turma_id DESC
                   LIMIT 1";
        $stmt = $this->pdo->prepare($sqlDoc);
        $stmt->execute([':id' => $pessoaId]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function atualizarVinculoAluno(int $pessoaId, ?int $turmaId): bool
    {
        try {
            $this->pdo->beginTransaction();
            $del = $this->pdo->prepare("DELETE FROM aluno_turma WHERE pessoa_id = :id");
            $del->execute([':id' => $pessoaId]);
            if ($turmaId !== null) {
                $ins = $this->pdo->prepare("INSERT INTO aluno_turma (pessoa_id, turma_id, data_matricula) VALUES (:pid, :tid, CURDATE())");
                $ins->execute([':pid' => $pessoaId, ':tid' => $turmaId]);
            }
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $this->ultimoErro = 'Erro ao atualizar vínculo de aluno';
            return false;
        }
    }

    public function atualizarVinculoDocente(int $pessoaId, ?int $turmaId): bool
    {
        try {
            $this->pdo->beginTransaction();
            $del = $this->pdo->prepare("DELETE FROM docente_turma WHERE pessoa_id = :id");
            $del->execute([':id' => $pessoaId]);
            if ($turmaId !== null) {
                $ins = $this->pdo->prepare("INSERT INTO docente_turma (pessoa_id, turma_id, data_associacao) VALUES (:pid, :tid, CURDATE())");
                $ins->execute([':pid' => $pessoaId, ':tid' => $turmaId]);
            }
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $this->ultimoErro = 'Erro ao atualizar vínculo de docente';
            return false;
        }
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
    public function deletarPessoa(int $id, string $perfil): bool
    {
        try {
            $this->pdo->beginTransaction();

            // Remover vínculos sem usar CASCADE
            $stmt = $this->pdo->prepare("DELETE FROM aluno_turma WHERE pessoa_id = :id");
            $stmt->execute([':id' => $id]);

            $stmt = $this->pdo->prepare("DELETE FROM docente_turma WHERE pessoa_id = :id");
            $stmt->execute([':id' => $id]);

            $stmt = $this->pdo->prepare("DELETE FROM usuario WHERE pessoa_id = :id");
            $stmt->execute([':id' => $id]);

            // Excluir a pessoa
            $stmt2 = $this->pdo->prepare("DELETE FROM pessoa WHERE pessoa_id = :id");
            $ok = $stmt2->execute([':id' => $id]);

            $this->pdo->commit();
            return $ok;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            $this->ultimoErro = 'Erro ao excluir pessoa: ' . $e->getMessage();
            return false;
        }
    }

    public function getUltimoErro(): ?string
    {
        return $this->ultimoErro;
    }


    // Listar todas as pessoas
    public function listarPessoas(): array
    {
        $sql = "SELECT * FROM pessoa";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function listarPessoasTable(int $limit, int $offset): array
    {
        $sql = "
            SELECT 
                p.pessoa_id,
                p.nome,
                p.perfil,
                MAX(COALESCE(poA.nome, poD.nome)) AS nome_polo
            FROM pessoa p
            LEFT JOIN aluno_turma at ON p.pessoa_id = at.pessoa_id
            LEFT JOIN turma tA ON at.turma_id = tA.turma_id
            LEFT JOIN polo poA ON tA.polo_id = poA.polo_id
            LEFT JOIN docente_turma dt ON p.pessoa_id = dt.pessoa_id
            LEFT JOIN turma tD ON dt.turma_id = tD.turma_id
            LEFT JOIN polo poD ON tD.polo_id = poD.polo_id
            GROUP BY p.pessoa_id, p.nome, p.perfil
            ORDER BY p.nome ASC
            LIMIT :limit OFFSET :offset
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
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
}
