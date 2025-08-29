<?php

require_once __DIR__ . "/BaseModel.php";

class PesquisaModel extends BaseModel
{
    protected $tabela = 'turma';

    public function __construct()
    {
        parent::__construct();
    }

    public function buscarAlunosSemVinculo(int $limite, int $offset, string $termo = ''): array
    {
        try {
            $query = "  
                SELECT 
                    pessoa.pessoa_id,
                    pessoa.nome,
                    pessoa.email
                FROM 
                    pessoa
                WHERE 
                    pessoa.perfil = 'aluno'
                    AND NOT EXISTS (
                        SELECT 1 
                        FROM aluno_turma 
                        WHERE aluno_turma.pessoa_id = pessoa.pessoa_id
                    )
            ";

            if (!empty($termo)) {
                $query .= " AND pessoa.nome LIKE :termo";
            }

            $query .= " ORDER BY pessoa.nome ASC LIMIT :limite OFFSET :offset";

            $stmt = $this->pdo->prepare($query);

            if (!empty($termo)) {
                $stmt->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
            }
            $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // var_dump($resultado);
            return $resultado;
        } catch (PDOException $e) {
            error_log("Erro ao buscar alunos sem vínculo: " . $e->getMessage());
            var_dump("deu errado");
        }
    }

}
