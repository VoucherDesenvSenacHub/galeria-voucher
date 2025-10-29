<?php
require_once __DIR__ . "/BaseModel.php";
require_once __DIR__ . "/ImagemProjetoDiaModel.php"; // Required

class ProjetoModel extends BaseModel
{

    public function __construct()
    {
        $this->tabela = "projeto";
        parent::__construct();
    }

    public function buscarProjetosPorTurma(int $turmaId): array
    {
        $sql = "SELECT * FROM projeto WHERE turma_id = :turma_id ORDER BY nome ASC"; // Adicionado ORDER BY
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function buscarDiasProjeto(int $projetoId): array
    {
        $sql = "SELECT * FROM projeto_dia WHERE projeto_id = :projeto_id ORDER BY FIELD(tipo_dia, 'I', 'P', 'E')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':projeto_id', $projetoId, PDO::PARAM_INT);
        $stmt->execute();
        $dias = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Instancia fora do loop para eficiência
        $imagemProjetoDiaModel = new ImagemProjetoDiaModel();
        foreach ($dias as &$dia) {
            // Use a chave correta conforme o banco
            $dia['id'] = $dia['projeto_dia_id'];
            $dia['imagens'] = $imagemProjetoDiaModel->buscarPorProjetoDia($dia['projeto_dia_id']);
        }
        unset($dia); // Desfaz a referência da última iteração
        return $dias;
    }

    /**
     * Cria um projeto completo com seus dias e imagens associadas.
     * Utiliza uma transação para garantir a integridade dos dados.
     *
     * @param array $dadosProjeto Dados do projeto contendo nome, descricao, link, turma_id e um array 'dias'
     * com chaves 'I', 'P', 'E', cada uma contendo 'descricao' e 'imagem_id'.
     * @return int|false Retorna o ID do projeto criado em caso de sucesso, ou false em caso de falha.
     */
    public function criarProjetoCompleto(array $dadosProjeto): int|false
    {
        // Instancia fora do loop
        $imagemProjetoDiaModel = new ImagemProjetoDiaModel();

        $this->pdo->beginTransaction();
        // try {
            // 1. Inserir o projeto principal
            error_log("[criarProjetoCompleto] Iniciando inserção do projeto: " . $dadosProjeto['nome']);
            $sqlProjeto = "INSERT INTO projeto (nome, descricao, link, turma_id) VALUES (:nome, :descricao, :link, :turma_id)";
            $stmtProjeto = $this->pdo->prepare($sqlProjeto);
            $stmtProjeto->execute([
                ':nome' => $dadosProjeto['nome'],
                ':descricao' => $dadosProjeto['descricao'],
                ':link' => !empty($dadosProjeto['link']) ? $dadosProjeto['link'] : null,
                ':turma_id' => $dadosProjeto['turma_id']
            ]);
            $projetoId = $this->pdo->lastInsertId();

            // Verifica se lastInsertId retornou algo válido
            if (!$projetoId || $projetoId === '0') {
                 error_log("[criarProjetoCompleto] ERRO: Falha ao obter lastInsertId após inserir projeto principal.");
                 throw new Exception("Falha ao inserir projeto principal (ID não retornado).");
            }
             error_log("[criarProjetoCompleto] Projeto principal ID {$projetoId} inserido com sucesso.");


            // 2. Inserir os dias do projeto e associar imagens
            $sqlDia = "INSERT INTO projeto_dia (tipo_dia, descricao, projeto_id) VALUES (:tipo_dia, :descricao, :projeto_id)";
            $stmtDia = $this->pdo->prepare($sqlDia);

            foreach ($dadosProjeto['dias'] as $tipoDia => $diaData) {
                 error_log("[criarProjetoCompleto] Processando Dia '{$tipoDia}' para Projeto ID {$projetoId}. Descricao: " . (!empty($diaData['descricao']) ? 'Sim' : 'Não') . ", Imagem ID: " . ($diaData['imagem_id'] ?? 'Nenhum'));

                 // Insere o dia
                 $stmtDia->execute([
                     ':tipo_dia' => $tipoDia,
                     ':descricao' => !empty($diaData['descricao']) ? $diaData['descricao'] : null, // Permite descrição nula
                     ':projeto_id' => $projetoId
                 ]);
                 $projetoDiaId = $this->pdo->lastInsertId();

                 // Verifica se lastInsertId retornou algo válido
                 if (!$projetoDiaId || $projetoDiaId === '0') {
                     error_log("[criarProjetoCompleto] ERRO: Falha ao obter lastInsertId após inserir dia {$tipoDia} para projeto ID {$projetoId}.");
                     throw new Exception("Falha ao inserir dia {$tipoDia} do projeto (ID não retornado).");
                 }
                 error_log("[criarProjetoCompleto] Dia '{$tipoDia}' (ID: {$projetoDiaId}) inserido para Projeto ID {$projetoId}.");

                 // Associa a imagem ao dia, se houver imagem_id
                 if (!empty($diaData['imagem_id'])) {
                    error_log("[criarProjetoCompleto] Tentando associar imagem ID {$diaData['imagem_id']} ao dia ID {$projetoDiaId}.");
                    $associacaoSucesso = $imagemProjetoDiaModel->associarImagemDia($diaData['imagem_id'], $projetoDiaId, $projetoId);
                     if (!$associacaoSucesso) {
                         // O método associarImagemDia já loga o erro PDO específico
                         error_log("[criarProjetoCompleto] ERRO: Falha retornada por associarImagemDia para imagem ID {$diaData['imagem_id']} e dia ID {$projetoDiaId}.");
                         throw new Exception("Falha ao associar imagem ao dia {$tipoDia}. Verifique os logs para detalhes.");
                     }
                      error_log("[criarProjetoCompleto] Associação bem-sucedida para imagem ID {$diaData['imagem_id']} e dia ID {$projetoDiaId}.");
                 } else {
                     error_log("[criarProjetoCompleto] Nenhuma imagem para associar ao dia ID {$projetoDiaId}.");
                 }
            }


            // 3. Commit da transação se tudo ocorreu bem
            $this->pdo->commit();
             error_log("[criarProjetoCompleto] SUCESSO: Projeto ID {$projetoId} e seus dias/imagens foram criados com sucesso.");
            return (int)$projetoId;

        // } catch (Exception $e) {
        //     // 4. Rollback em caso de erro
        //     $this->pdo->rollBack();
        //     // Loga a mensagem da exceção específica que causou o rollback
        //     error_log("[criarProjetoCompleto] ERRO GERAL: Erro durante a transação, rollback executado: " . $e->getMessage());
        //     return false;
        // }
    }
}