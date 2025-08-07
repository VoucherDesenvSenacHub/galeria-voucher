<?php

require_once __DIR__ . '/BaseModel.php';

class DocenteModel extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Busca docentes de uma turma específica, com a opção de filtrar por nome.
     *
     * @param int $turma_id O ID da turma.
     * @param string|null $pesquisa_docente O termo de pesquisa para o nome do docente.
     * @return array A lista de docentes encontrados.
     */
    public function buscarDocentesPorTurma(int $turma_id, ?string $pesquisa_docente = null): array
    {
        // Parâmetros para a consulta SQL
        $params = [':turma_id' => $turma_id];

        // Query base para buscar os docentes, usando os joins necessários
        $query = "
            SELECT
                p.nome,
                po.nome AS polo
            FROM
                docente_turma dt
            JOIN
                pessoa p ON dt.pessoa_id = p.pessoa_id
            JOIN
                turma t ON dt.turma_id = t.turma_id
            JOIN
                polo po ON t.polo_id = po.polo_id
            WHERE
                dt.turma_id = :turma_id
        ";

        // Adiciona o filtro de pesquisa se um termo for fornecido
        if (!empty($pesquisa_docente)) {
            $query .= " AND p.nome LIKE :pesquisa_docente";
            $params[':pesquisa_docente'] = '%' . $pesquisa_docente . '%';
        }

        // Ordena o resultado pelo nome do docente
        $query .= " ORDER BY p.nome ASC";

        // Prepara e executa a consulta de forma segura
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}