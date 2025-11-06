TurmaModel.php

<?php

require_once __DIR__ . "/BaseModel.php";

class TurmaModel extends BaseModel
{
    protected $tabela = 'turma';

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
            // Inicia uma transação.
            $this->pdo->beginTransaction();

            // 1. Buscar todos os projetos (projeto_id) associados à turma
            $stmtProjIds = $this->pdo->prepare("SELECT projeto_id FROM projeto WHERE turma_id = :id");
            $stmtProjIds->execute([':id' => $id]);
            $projectIds = $stmtProjIds->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($projectIds)) {
                // Cria placeholders para a cláusula IN ()
                $projectPlaceholders = rtrim(str_repeat('?,', count($projectIds)), ',');

                // 2. Buscar todos os dias (projeto_dia_id) desses projetos
                $stmtDiaIds = $this->pdo->prepare("SELECT projeto_dia_id FROM projeto_dia WHERE projeto_id IN ($projectPlaceholders)");
                $stmtDiaIds->execute($projectIds);
                $diaIds = $stmtDiaIds->fetchAll(PDO::FETCH_COLUMN);

                if (!empty($diaIds)) {
                    // 3. Excluir os registros "netos" (imagem_projeto_dia)
                    $diaPlaceholders = rtrim(str_repeat('?,', count($diaIds)), ',');
                    $stmtImgDia = $this->pdo->prepare("DELETE FROM imagem_projeto_dia WHERE projeto_dia_id IN ($diaPlaceholders)");
                    $stmtImgDia->execute($diaIds);
                }
                
                // 4. Excluir os registros "filhos" (projeto_dia)
                $stmtDia = $this->pdo->prepare("DELETE FROM projeto_dia WHERE projeto_id IN ($projectPlaceholders)");
                $stmtDia->execute($projectIds);
            }

            // 5. Excluir associações de alunos
            $stmt1 = $this->pdo->prepare("DELETE FROM aluno_turma WHERE turma_id = :id");
            $stmt1->execute([':id' => $id]);

            // 6. Excluir associações de docentes
            $stmt2 = $this->pdo->prepare("DELETE FROM docente_turma WHERE turma_id = :id");
            $stmt2->execute([':id' => $id]);

            // 7. Excluir os projetos (agora órfãos)
            $stmt3 = $this->pdo->prepare("DELETE FROM projeto WHERE turma_id = :id");
            $stmt3->execute([':id' => $id]);

            // 8. Finalmente, excluir a própria turma
            $stmtFinal = $this->pdo->prepare("DELETE FROM turma WHERE turma_id = :id");
            $stmtFinal->execute([':id' => $id]);

            // Se tudo deu certo, confirma as alterações.
            $this->pdo->commit();
            return true;
            
        } catch (PDOException $e) {
            // Se algo deu errado, desfaz tudo.
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

    /**
     * Conta o total de turmas, opcionalmente filtrando por um termo de busca.
     * @param string $termo O termo para filtrar a contagem.
     * @return int O número total de turmas.
     */
    public function contarTotalTurmas(string $termo = ''): int
    {
        $query = "SELECT COUNT(t.turma_id) 
                  FROM turma t
                  JOIN polo p ON t.polo_id = p.polo_id";
        
        if (!empty($termo)) {
            $query .= " WHERE t.nome LIKE :termo OR p.nome LIKE :termo";
        }

        $stmt = $this->pdo->prepare($query);
        
        if (!empty($termo)) {
            $stmt->execute([':termo' => '%' . $termo . '%']);
        } else {
            $stmt->execute();
        }

        return (int)$stmt->fetchColumn();
    }

    /**
     * Busca turmas com paginação e filtro.
     * @param int $limite O número de registros por página.
     * @param int $offset O deslocamento (a partir de qual registro buscar).
     * @param string $termo O termo de busca.
     * @return array A lista de turmas da página.
     */
    public function buscarTurmasPaginado(int $limite, int $offset, string $termo = ''): array
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
        ";
        
        if (!empty($termo)) {
            $query .= " WHERE t.nome LIKE :termo OR p.nome LIKE :termo";
        }

        $query .= " ORDER BY t.nome ASC LIMIT :limite OFFSET :offset";

        $stmt = $this->pdo->prepare($query);

        if (!empty($termo)) {
            $stmt->bindValue(':termo', '%' . $termo . '%', PDO::PARAM_STR);
        }
        $stmt->bindValue(':limite', $limite, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lista todas as turmas com seus polos (para selects), ordenadas por nome.
     */
    public function listarTodasTurmasComPolo(): array
    {
        $sql = "SELECT t.turma_id, t.nome AS nome_turma, t.polo_id, p.nome AS nome_polo
                FROM turma t
                INNER JOIN polo p ON t.polo_id = p.polo_id
                ORDER BY t.nome ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lista turmas por polo.
     */
    public function listarTurmasPorPolo(int $poloId): array
    {
        $sql = "SELECT turma_id, nome FROM turma WHERE polo_id = :polo ORDER BY nome ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':polo', $poloId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca uma turma específica com seus projetos associados.
     * @param int $idTurma O ID da turma.
     * @return array Array com dados da turma e projetos.
     */
    public function buscarTurmaProjetoID(int $idTurma): array
    {
        $query = "SELECT t.nome as nomeTurma, 
                t.descricao as descricaoTurma, 
                p.nome as nomeProjeto, 
                p.descricao as descricaoProjeto, 
                p.link linkProjeto 
                from turma as t 
                Left join projeto as p 
                on t.turma_id = p.turma_id
                where t.turma_id = :idTurma";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':idTurma', $idTurma, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca uma turma por ID com informações completas.
     * @param int $id O ID da turma.
     * @return array|null Array com dados da turma ou null se não encontrada.
     */
    public function buscarPorId(int $id): ?array
    {
        $sql = "SELECT
                t.*,
                i.url AS imagem,
                p.nome AS polo,
                c.nome AS cidade
                FROM turma t
                LEFT JOIN imagem i ON t.imagem_id = i.imagem_id
                LEFT JOIN polo p ON t.polo_id = p.polo_id
                LEFT JOIN cidade c ON p.cidade_id = c.cidade_id
                WHERE t.turma_id = :id LIMIT 1";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    /**
     * Busca todos os projetos com descrições completas, incluindo turma, polo e imagem.
     * @return array Array com todos os projetos e suas informações relacionadas.
     */
    public function buscarProjetosComDescricao(): array
    {
        $query = "
            SELECT 
                pr.projeto_id,
                pr.nome AS NOME_PROJETO,
                pr.descricao AS DESCRICAO_PROJETO,
                pr.link AS LINK_PROJETO,
                t.nome AS NOME_TURMA,
                p.nome AS NOME_POLO,
                i.url AS URL_IMAGEM,
                i.descricao AS DESCRICAO_IMAGEM
            FROM 
                projeto pr
            JOIN 
                turma t ON pr.turma_id = t.turma_id
            JOIN 
                polo p ON t.polo_id = p.polo_id
            LEFT JOIN 
                imagem_projeto ip ON pr.projeto_id = ip.projeto_id
            LEFT JOIN 
                imagem i ON ip.imagem_id = i.imagem_id
            ORDER BY 
                pr.nome ASC
        ";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Busca projetos de uma turma específica com descrições completas.
     * @param int $turmaId O ID da turma.
     * @return array Array com projetos da turma e suas informações relacionadas.
     */
    /**
     * Busca projetos de uma turma específica com descrições completas.
     * @param int $turmaId O ID da turma.
     * @return array Array com projetos da turma e suas informações relacionadas.
     */
    public function buscarProjetosPorTurma(int $turmaId): array
    {
        // Query corrigida para refletir o novo schema (projeto_dia e imagem_projeto_dia)
        $query = "
            SELECT 
                pr.projeto_id,
                pr.nome AS NOME_PROJETO,
                pr.descricao AS DESCRICAO_PROJETO,
                pr.link AS LINK_PROJETO,
                t.nome AS NOME_TURMA,
                p.nome AS NOME_POLO,
                MIN(i.url) AS URL_IMAGEM, -- Pega a primeira imagem encontrada para o projeto
                MIN(i.descricao) AS DESCRICAO_IMAGEM
            FROM 
                projeto pr
            JOIN 
                turma t ON pr.turma_id = t.turma_id
            JOIN 
                polo p ON t.polo_id = p.polo_id
            LEFT JOIN 
                projeto_dia pd ON pr.projeto_id = pd.projeto_id -- Junção com a nova tabela projeto_dia
            LEFT JOIN 
                imagem_projeto_dia ipd ON pd.projeto_dia_id = ipd.projeto_dia_id -- Junção com a tabela renomeada
            LEFT JOIN 
                imagem i ON ipd.imagem_id = i.imagem_id
            WHERE 
                t.turma_id = :turmaId
            GROUP BY -- Agrupa para evitar duplicatas de projetos
                pr.projeto_id, pr.nome, pr.descricao, pr.link, t.nome, p.nome
            ORDER BY 
                pr.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':turmaId', $turmaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function VincularDocenteComTurma(int $id_pessoa, int $id_turma){
        $sql = 'INSERT INTO docente_turma (pessoa_id, turma_id, data_associacao) 
                VALUES (:id_pessoa, :id_turma, NOW())';
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':id_pessoa' => $id_pessoa,
            ':id_turma' => $id_turma
        ]);
    }
}
