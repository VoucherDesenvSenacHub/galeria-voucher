<?php

require_once __DIR__ . "/BaseModel.php";
require_once __DIR__ . "/ImagemProjetoDiaModel.php"; // Necessário para buscar e associar imagens

class ProjetoModel extends BaseModel
{

    protected $tabela = "projeto"; // Define a tabela no atributo da classe
    private ImagemProjetoDiaModel $imagemProjetoDiaModel; // Injeção de dependência

    public function __construct()
    {
        parent::__construct();
        $this->imagemProjetoDiaModel = new ImagemProjetoDiaModel();
    }

    /**
     * Busca todos os projetos associados a uma turma específica.
     *
     * @param int $turmaId O ID da turma.
     * @return array Array de projetos encontrados, ordenados por nome. Retorna array vazio se não encontrar ou em erro.
     */
    public function buscarProjetosPorTurma(int $turmaId): array
    {
        $sql = "SELECT * FROM {$this->tabela} WHERE turma_id = :turma_id ORDER BY nome ASC";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("[{$this->tabela}Model::buscarProjetosPorTurma] Erro ao buscar projetos para turma ID {$turmaId}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Busca os detalhes dos dias (fases I, P, E) de um projeto específico, incluindo suas imagens associadas.
     *
     * @param int $projetoId O ID do projeto.
     * @return array Array com os dados dos dias do projeto. Retorna array vazio se não encontrar ou em erro.
     */
    public function buscarDiasProjeto(int $projetoId): array
    {
        $sql = "SELECT * FROM projeto_dia WHERE projeto_id = :projeto_id ORDER BY FIELD(tipo_dia, 'I', 'P', 'E')";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':projeto_id', $projetoId, PDO::PARAM_INT);
            $stmt->execute();
            $dias = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($dias as &$dia) {
                $dia['id'] = $dia['projeto_dia_id'];
                $dia['imagens'] = $this->imagemProjetoDiaModel->buscarPorProjetoDia((int) $dia['projeto_dia_id']);
            }
            unset($dia);

            return $dias;
        } catch (PDOException $e) {
            error_log("[{$this->tabela}Model::buscarDiasProjeto] Erro ao buscar dias para projeto ID {$projetoId}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Insere o registro principal do projeto. (Método privado auxiliar)
     *
     * @param string $nome Nome do projeto.
     * @param string|null $descricao Descrição geral.
     * @param string|null $link Link do projeto.
     * @param int $turmaId ID da turma associada.
     * @return int O ID do projeto inserido.
     * @throws Exception Se a inserção falhar ou a turma_id for inválida.
     */
    private function inserirProjetoPrincipal(string $nome, ?string $descricao, ?string $link, int $turmaId): int
    {
        error_log("[_inserirProjetoPrincipal] Inserindo projeto '{$nome}' para turma ID {$turmaId}.");

        if (!$this->verificarExistencia('turma', 'turma_id', $turmaId)) {
            throw new Exception("Chave estrangeira inválida: Turma ID {$turmaId} não existe.");
        }

        $sqlProjeto = "INSERT INTO {$this->tabela} (nome, descricao, link, turma_id) VALUES (:nome, :descricao, :link, :turma_id)";
        $stmtProjeto = $this->pdo->prepare($sqlProjeto);
        $executou = $stmtProjeto->execute([
            ':nome' => $nome,
            ':descricao' => $descricao,
            ':link' => $link,
            ':turma_id' => $turmaId
        ]);

        if (!$executou) {
            $errorInfo = $stmtProjeto->errorInfo();
            throw new Exception("Falha SQL ao inserir projeto: " . ($errorInfo[2] ?? 'Erro desconhecido.'));
        }

        $projetoId = (int) $this->pdo->lastInsertId();
        if ($projetoId === 0) {
            throw new Exception("Falha ao obter ID do projeto inserido.");
        }
        error_log("[_inserirProjetoPrincipal] OK: Projeto principal ID {$projetoId} inserido.");
        return $projetoId;
    }

    /**
     * Insere um registro de dia (fase) para um projeto. (Método privado auxiliar)
     *
     * @param string $tipoDia Tipo do dia ('I', 'P', 'E').
     * @param string|null $descricao Descrição da fase.
     * @param int $projetoId ID do projeto pai.
     * @return int O ID do dia do projeto inserido.
     * @throws Exception Se a inserção falhar.
     */
    private function inserirProjetoDia(string $tipoDia, ?string $descricao, int $projetoId): int
    {
        if (!in_array($tipoDia, ['I', 'P', 'E'])) {
            throw new InvalidArgumentException("Tipo de dia inválido '{$tipoDia}' fornecido.");
        }

        error_log("[_inserirProjetoDia] Inserindo Dia '{$tipoDia}' para Projeto ID {$projetoId}.");
        $sqlDia = "INSERT INTO projeto_dia (tipo_dia, descricao, projeto_id) VALUES (:tipo_dia, :descricao, :projeto_id)";
        $stmtDia = $this->pdo->prepare($sqlDia);
        $executou = $stmtDia->execute([
            ':tipo_dia' => $tipoDia,
            ':descricao' => $descricao,
            ':projeto_id' => $projetoId
        ]);

        if (!$executou) {
            $errorInfo = $stmtDia->errorInfo();
            throw new Exception("Falha SQL ao inserir dia {$tipoDia}: " . ($errorInfo[2] ?? 'Erro desconhecido.'));
        }

        $projetoDiaId = (int) $this->pdo->lastInsertId();
        if ($projetoDiaId === 0) {
            throw new Exception("Falha ao obter ID do dia {$tipoDia} inserido.");
        }
        error_log("[_inserirProjetoDia] OK: Dia '{$tipoDia}' (ID: {$projetoDiaId}) inserido.");
        return $projetoDiaId;
    }

    /**
     * Cria um projeto completo com seus dias (fases) e associações de imagens, usando uma transação.
     *
     * @param array $dadosProjeto (Ver descrição no método original)
     * @return int|false Retorna o ID do projeto criado em caso de sucesso, ou false em caso de falha na transação.
     */
    public function criarProjetoCompleto(array $dadosProjeto): int|false
    {
        if (empty($dadosProjeto['nome']) || empty($dadosProjeto['turma_id'])) {
            error_log("[{$this->tabela}Model::criarProjetoCompleto] ERRO: Nome do projeto ou ID da turma não fornecidos.");
            return false;
        }

        try {
            $projetoId = $this->inserirProjetoPrincipal(
                $dadosProjeto['nome'],
                !empty($dadosProjeto['descricao']) ? $dadosProjeto['descricao'] : null,
                !empty($dadosProjeto['link']) ? $dadosProjeto['link'] : null,
                (int) $dadosProjeto['turma_id']
            );

            foreach ($dadosProjeto['dias'] as $tipoDia => $diaData) {
                $projetoDiaId = $this->inserirProjetoDia(
                    $tipoDia,
                    !empty($diaData['descricao']) ? $diaData['descricao'] : null,
                    $projetoId
                );

                if (!empty($diaData['imagem_id'])) {
                    $imagemId = (int) $diaData['imagem_id'];
                    error_log("[{$this->tabela}Model::criarProjetoCompleto] Passo 2 (Img Assoc): Associando imagem ID {$imagemId} ao dia ID {$projetoDiaId}.");

                    if (!$this->verificarExistencia('imagem', 'imagem_id', $imagemId)) {
                        throw new Exception("Chave estrangeira inválida: Imagem ID {$imagemId} não existe.");
                    }
                    
                    $associacaoSucesso = $this->imagemProjetoDiaModel->associarImagemDia($imagemId, $projetoDiaId);
                    if (!$associacaoSucesso) {
                        throw new Exception("Falha ao associar imagem ID {$imagemId} ao dia {$tipoDia} (ID: {$projetoDiaId}). Verifique os logs.");
                    }
                    error_log("[{$this->tabela}Model::criarProjetoCompleto] Passo 2 OK (Img Assoc): Associação bem-sucedida.");
                }
            }

            error_log("[{$this->tabela}Model::criarProjetoCompleto] SUCESSO: Transação commitada. Projeto ID {$projetoId} criado.");
            return $projetoId;

        } catch (PDOException | InvalidArgumentException | Exception $e) {
            error_log("[{$this->tabela}Model::criarProjetoCompleto] ERRO: Rollback executado. Mensagem: " . $e->getMessage());
            throw $e;
        }
    }
    
    public function editarProjeto(array $dados): bool
    {
        error_log("[editarProjeto] Iniciando edição do projeto ID {$dados['projetoId']}.");

        if (!isset($dados['dias']) || !is_array($dados['dias'])) {
            throw new Exception("Array 'dias' não fornecido ou inválido.");
        }

        $imageService = new ImagensUploadService();

        try {
            // Inicia transação
            $this->pdo->beginTransaction();

            // =============================
            // 1. ATUALIZA PROJETO PRINCIPAL
            // =============================
            $sqlProjeto = "UPDATE {$this->tabela}
                        SET nome = :nome,
                            descricao = :descricao,
                            link = :link
                        WHERE projeto_id = :projetoId";

            $stmtProjeto = $this->pdo->prepare($sqlProjeto);
            $executou = $stmtProjeto->execute([
                ':nome'       => $dados['nomeProjeto'],
                ':descricao'  => $dados['descricaoProjeto'],
                ':link'       => $dados['linkProjeto'],
                ':projetoId'  => $dados['projetoId']
            ]);

            if (!$executou) {
                $errorInfo = $stmtProjeto->errorInfo();
                throw new Exception("Falha ao atualizar projeto: " . ($errorInfo[2] ?? 'Erro desconhecido'));
            }

            error_log("[editarProjeto] Projeto principal atualizado.");

            // =============================
            // 2. ATUALIZA DIAS E IMAGENS
            // =============================
            foreach ($dados['dias'] as $tipoDia => $dia) {
                
                if (isset($dia['arquivo_enviado']) && $dia['arquivo_enviado']['error'] === UPLOAD_ERR_OK) {


                    $result = $imageService->salvarArquivo($dia['arquivo_enviado'], 'projeto_dia');


                    if (!$result['success']) {
                        throw new Exception("Falha ao mover imagem do dia {$tipoDia}");
                    }

                    $sqlImg = "UPDATE imagem
                            SET url = :url
                            WHERE imagem_id = :id";

                    $stmtImg = $this->pdo->prepare($sqlImg);
                    $executou = $stmtImg->execute([
                        ':url' => $result['caminho'],
                        ':id'  => $dia['img_id']
                    ]);

                    if (!$executou) {
                        throw new Exception("Falha ao atualizar imagem do dia {$tipoDia}");
                    }
                }
            }

            // Finaliza transação
            $this->pdo->commit();
            error_log("[editarProjeto] ✅ PROJETO EDITADO COM SUCESSO.");

            return true;

        } catch (Throwable $e) {

            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }

            error_log("[editarProjeto] ❌ ERRO: " . $e->getMessage());
            throw $e;
        }
    }



    /**
     * Função auxiliar para verificar a existência de um registro em uma tabela.
     *
     * @param string $tabela Nome da tabela.
     * @param string $coluna Nome da coluna ID.
     * @param int $id Valor do ID a ser verificado.
     * @return bool True se o registro existe, false caso contrário ou em erro.
     */
    private function verificarExistencia(string $tabela, string $coluna, int $id): bool
    {
        try {
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $tabela) || !preg_match('/^[a-zA-Z0-9_]+$/', $coluna)) {
                throw new InvalidArgumentException("Nome de tabela ou coluna inválido para verificação: {$tabela}.{$coluna}");
            }
            $sql = "SELECT 1 FROM `{$tabela}` WHERE `{$coluna}` = :id LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchColumn() !== false;
        } catch (PDOException | InvalidArgumentException $e) {
            error_log("[{$this->tabela}Model::verificarExistencia] Erro ao verificar {$coluna} = {$id} em {$tabela}: " . $e->getMessage());
            return false;
        }
    }

    public function getProjetoDiaID(int $turmaId, int $projetoId){
        $sql = "SELECT
                	p.projeto_id ID_PROJETO,
                	P.nome NOME_PROJETO, 
                    P.descricao DESCRICAO_PROJETO, 
                    P.link LINK_PROJETO,
                    PD.tipo_dia DIA_PROJETO,
                    PD.descricao DESC_DIA_PROJETO,
                    PD.projeto_dia_id ID_DIA_PROJETO,
                    I.url URL_IMG_PROJETO,
                    I.imagem_id IMG_ID
                FROM projeto p
                JOIN projeto_dia PD
                    ON P.projeto_id = PD.projeto_id
                JOIN TURMA T 
                    ON P.turma_id = T.turma_id
                JOIN imagem_projeto_dia IPD
                    ON PD.projeto_dia_id = IPD.projeto_dia_id
                JOIN imagem I
                    ON IPD.imagem_id = I.imagem_id
                WHERE T.turma_id = :turmaId
                AND P.projeto_id = :projetoId";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(":turmaId", $turmaId, PDO::PARAM_INT);
        $stmt->bindValue(":projetoId", $projetoId, PDO::PARAM_INT);

        $stmt->execute(); 

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Exclui um projeto e todos os seus dados dependentes (dias, associações de imagens).
     * Usa uma transação para garantir a integridade dos dados.
     *
     * @param int $projetoId O ID do projeto a ser excluído.
     * @return bool Retorna `true` se tudo foi excluído com sucesso, `false` caso contrário.
     */
    public function excluirProjeto(int $projetoId): bool
    {
        try {
            // Inicia uma transação
            $this->pdo->beginTransaction();

            // 1. Buscar todos os dias (projeto_dia_id) associados ao projeto
            $stmtDiaIds = $this->pdo->prepare("SELECT projeto_dia_id FROM projeto_dia WHERE projeto_id = :id");
            $stmtDiaIds->execute([':id' => $projetoId]);
            $diaIds = $stmtDiaIds->fetchAll(PDO::FETCH_COLUMN);

            if (!empty($diaIds)) {
                // 2. Criar placeholders para a cláusula IN ()
                $diaPlaceholders = rtrim(str_repeat('?,', count($diaIds)), ',');

                // 3. Excluir os registros "netos" (imagem_projeto_dia)
                $stmtImgDia = $this->pdo->prepare("DELETE FROM imagem_projeto_dia WHERE projeto_dia_id IN ($diaPlaceholders)");
                $stmtImgDia->execute($diaIds);
            }
            
            // 4. Excluir os registros "filhos" (projeto_dia)
            $stmtDia = $this->pdo->prepare("DELETE FROM projeto_dia WHERE projeto_id = :id");
            $stmtDia->execute([':id' => $projetoId]);

            // 5. Finalmente, excluir o próprio projeto
            $stmtProjeto = $this->pdo->prepare("DELETE FROM {$this->tabela} WHERE projeto_id = :id");
            $stmtProjeto->execute([':id' => $projetoId]);

            // Se tudo deu certo, confirma as alterações.
            $this->pdo->commit();
            return true;
            
        } catch (PDOException $e) {
            // Se algo deu errado, desfaz tudo.
            $this->pdo->rollBack();
            error_log("[{$this->tabela}Model::excluirProjeto] Erro ao excluir projeto ID {$projetoId}: " . $e->getMessage());
            return false;
        }
    }
}
