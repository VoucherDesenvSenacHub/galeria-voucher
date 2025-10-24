<?php
require_once __DIR__ . "/BaseModel.php";
require_once __DIR__ . "/ImagemProjetoDiaModel.php"; // Dependência para buscar imagens dos dias

class ProjetoModel extends BaseModel
{
    // Define a tabela principal deste modelo
    protected $tabela = "projeto";

    // Construtor: chama o construtor da classe pai para conectar ao banco
    public function __construct()
    {
        parent::__construct();
    }

     /**
     * Permite acesso à conexão PDO, útil para controle de transações pelo Controller.
     * @return PDO A instância PDO da conexão com o banco.
     */
     public function getPdo(): PDO
     {
         return $this->pdo;
     }

    /**
     * Busca todos os projetos associados a uma turma específica.
     * Inclui a URL da imagem principal (capa) do projeto, se houver.
     *
     * @param int $turmaId O ID da turma.
     * @return array Um array de projetos, cada um com seus dados e URL da imagem principal.
     */
    public function buscarProjetosPorTurma(int $turmaId): array
    {
        // SQL para selecionar dados do projeto (p.*) e a URL da imagem associada (i.url)
        // Faz LEFT JOIN com imagem_projeto (tabela de junção) e depois com imagem
        $sql = "SELECT p.*, i.url as URL_IMAGEM
                FROM projeto p
                LEFT JOIN imagem_projeto ip ON p.projeto_id = ip.projeto_id -- Junção com tabela que liga projeto e imagem
                LEFT JOIN imagem i ON ip.imagem_id = i.imagem_id -- Junção com tabela de imagens para pegar a URL
                WHERE p.turma_id = :turma_id
                ORDER BY p.nome ASC"; // Ordena os projetos por nome

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT); // Associa o ID da turma ao placeholder
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os resultados encontrados
    }

    /**
     * Busca todos os dias (I, P, E) de um projeto específico, incluindo suas imagens associadas.
     *
     * @param int $projetoId O ID do projeto.
     * @return array Um array contendo os dados de cada dia e um subarray 'imagens' para cada dia.
     */
    public function buscarDiasProjeto(int $projetoId): array
    {
        // SQL para selecionar os dias, ordenados por I, P, E
        $sql = "SELECT * FROM projeto_dia WHERE projeto_id = :projeto_id ORDER BY FIELD(tipo_dia, 'I', 'P', 'E')";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':projeto_id', $projetoId, PDO::PARAM_INT);
        $stmt->execute();
        $dias = $stmt->fetchAll(PDO::FETCH_ASSOC); // Pega todos os dias

        // Instancia o modelo auxiliar para buscar as imagens de cada dia
        $imagemProjetoDiaModel = new ImagemProjetoDiaModel();
        // Itera sobre cada dia encontrado (usando referência '&' para modificar o array original)
        foreach ($dias as &$dia) {
            // Adiciona a chave 'id' para compatibilidade (embora já exista projeto_dia_id)
            $dia['id'] = $dia['projeto_dia_id'];
            // Busca as imagens associadas a este dia específico usando o modelo auxiliar
            $dia['imagens'] = $imagemProjetoDiaModel->buscarPorProjetoDia($dia['projeto_dia_id']);
        }
        unset($dia); // Remove a referência da última iteração para evitar efeitos colaterais
        return $dias; // Retorna o array de dias com as imagens aninhadas
    }

    /**
     * Cria um novo registro na tabela 'projeto'.
     *
     * @param string $nome Nome do projeto.
     * @param string $descricao Descrição do projeto.
     * @param string|null $link Link para o repositório ou site do projeto (opcional).
     * @param int $turmaId ID da turma à qual o projeto pertence.
     * @return int|false Retorna o ID do projeto recém-criado em caso de sucesso, ou false em caso de erro.
     */
    public function criarProjeto(string $nome, string $descricao, ?string $link, int $turmaId): int|false
    {
        // SQL para inserir um novo projeto (sem imagem_id, pois a associação é feita em outra tabela)
        $sql = "INSERT INTO projeto (nome, descricao, link, turma_id) VALUES (:nome, :descricao, :link, :turma_id)";
        try {
            $stmt = $this->pdo->prepare($sql);
            // Executa a query com os dados fornecidos
            $stmt->execute([
                ':nome' => $nome,
                ':descricao' => $descricao,
                ':link' => $link, // Pode ser null
                ':turma_id' => $turmaId
            ]);
            // Retorna o ID do último registro inserido
            return (int)$this->pdo->lastInsertId();
        } catch (PDOException $e) {
            // Em caso de erro, registra no log e retorna false
            error_log("Erro ao criar projeto: " . $e->getMessage());
            return false;
        }
    }

     /**
     * Associa uma imagem como capa de um projeto na tabela 'imagem_projeto'.
     * Esta tabela serve como ponte entre 'projeto' e 'imagem' para a imagem principal.
     *
     * @param int $projetoId ID do projeto.
     * @param int $imagemId ID da imagem a ser associada como capa.
     * @return bool True se a associação foi criada com sucesso, false caso contrário.
     */
    public function associarImagemCapaProjeto(int $projetoId, int $imagemId): bool
    {
        // Verifica se a associação já existe para evitar duplicatas (boa prática)
         $checkSql = "SELECT 1 FROM imagem_projeto WHERE projeto_id = :projeto_id AND imagem_id = :imagem_id LIMIT 1";
         $checkStmt = $this->pdo->prepare($checkSql);
         $checkStmt->execute([':projeto_id' => $projetoId, ':imagem_id' => $imagemId]);
         if ($checkStmt->fetch()) {
             // Se já existe, considera como sucesso (ou pode retornar um erro específico se preferir)
             return true;
         }

        // SQL para inserir a associação na tabela de junção 'imagem_projeto'
        $sql = "INSERT INTO imagem_projeto (projeto_id, imagem_id) VALUES (:projeto_id, :imagem_id)";
        try {
            $stmt = $this->pdo->prepare($sql);
            // Executa a inserção
            return $stmt->execute([
                ':projeto_id' => $projetoId,
                ':imagem_id' => $imagemId
            ]);
        } catch (PDOException $e) {
            // Em caso de erro, registra no log e retorna false
            error_log("Erro ao associar imagem de capa ao projeto [ProjetoID: {$projetoId}, ImagemID: {$imagemId}]: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Cria um novo registro na tabela 'projeto_dia'.
     * Representa uma fase do projeto (Início, Processo, Entrega).
     *
     * @param string $tipoDia O tipo do dia ('I', 'P', ou 'E').
     * @param string $descricao Descrição das atividades ou marcos desta fase.
     * @param int $projetoId ID do projeto ao qual esta fase pertence.
     * @return int|false Retorna o ID do dia ('projeto_dia_id') recém-criado, ou false em caso de erro.
     */
    public function criarProjetoDia(string $tipoDia, string $descricao, int $projetoId): int|false
    {
        // SQL para inserir um novo dia/fase do projeto
        $sql = "INSERT INTO projeto_dia (tipo_dia, descricao, projeto_id) VALUES (:tipo, :descricao, :projeto_id)";
        try {
            $stmt = $this->pdo->prepare($sql);
            // Executa a query com os dados
            $stmt->execute([
                ':tipo' => $tipoDia, // 'I', 'P', ou 'E'
                ':descricao' => $descricao,
                ':projeto_id' => $projetoId
            ]);
            // Retorna o ID do registro inserido
            return (int)$this->pdo->lastInsertId();
        } catch (PDOException $e) {
            // Tratamento especial para erro de chave duplicada (tentativa de inserir o mesmo tipo de dia para o mesmo projeto)
            if ($e->getCode() == '23000') { // Código SQLSTATE para violação de constraint UNIQUE
                 error_log("Erro ao criar dia do projeto: Dia '{$tipoDia}' já existe para o projeto ID {$projetoId}.");
                 // Decide o que fazer: retornar false, ou buscar e retornar o ID existente?
                 // Retornar false parece mais seguro para indicar falha na criação.
                 return false;
            } else {
                 // Outros erros de banco de dados
                 error_log("Erro ao criar dia do projeto ({$tipoDia}) para Projeto ID {$projetoId}: " . $e->getMessage());
                 return false;
            }
        }
    }

    /**
     * Associa uma imagem a um dia específico do projeto na tabela 'imagem_projeto_dia'.
     * Esta tabela liga a tabela 'imagem' com a tabela 'projeto_dia'.
     *
     * @param int $imagemId ID da imagem (da tabela 'imagem') a ser associada.
     * @param int $projetoDiaId ID do dia do projeto (da tabela 'projeto_dia').
     * @return bool True se a associação foi criada com sucesso, false caso contrário.
     */
    public function associarImagemProjetoDia(int $imagemId, int $projetoDiaId): bool
    {
         // Verifica se a associação já existe para evitar duplicatas (boa prática)
         $checkSql = "SELECT 1 FROM imagem_projeto_dia WHERE imagem_id = :imagem_id AND projeto_dia_id = :projeto_dia_id LIMIT 1";
         $checkStmt = $this->pdo->prepare($checkSql);
         $checkStmt->execute([':imagem_id' => $imagemId, ':projeto_dia_id' => $projetoDiaId]);
         if ($checkStmt->fetch()) {
             return true; // Já associado
         }

        // SQL para inserir a associação na tabela de junção 'imagem_projeto_dia'
        $sql = "INSERT INTO imagem_projeto_dia (imagem_id, projeto_dia_id) VALUES (:imagem_id, :projeto_dia_id)";
        try {
            $stmt = $this->pdo->prepare($sql);
            // Executa a inserção
            return $stmt->execute([
                ':imagem_id' => $imagemId,
                ':projeto_dia_id' => $projetoDiaId
            ]);
        } catch (PDOException $e) {
            // Em caso de erro, registra no log e retorna false
            error_log("Erro ao associar imagem [ID: {$imagemId}] ao dia do projeto [ID: {$projetoDiaId}]: " . $e->getMessage());
            return false;
        }
    }

    // --- Métodos Adicionais (Exemplo) ---
    // Você pode adicionar métodos para editar ou excluir projetos, dias, e associações de imagens aqui.
    // Lembre-se de usar transações se uma operação envolver múltiplas tabelas (ex: excluir um projeto e todas as suas dependências).

    /**
     * Exclui um projeto e todas as suas dependências (dias, associações de imagens).
     * IMPORTANTE: Usar com cuidado! Esta ação é irreversível.
     *
     * @param int $projetoId O ID do projeto a ser excluído.
     * @return bool True se excluído com sucesso, false caso contrário.
     */
    public function excluirProjetoCompleto(int $projetoId): bool
    {
        try {
            $this->pdo->beginTransaction();

            // 1. Encontrar IDs dos dias associados ao projeto
            $sqlDias = "SELECT projeto_dia_id FROM projeto_dia WHERE projeto_id = :projeto_id";
            $stmtDias = $this->pdo->prepare($sqlDias);
            $stmtDias->execute([':projeto_id' => $projetoId]);
            $diasIds = $stmtDias->fetchAll(PDO::FETCH_COLUMN);

            // 2. Excluir associações de imagens aos dias (se houver dias)
            if (!empty($diasIds)) {
                // Cria placeholders (?, ?, ?) para a cláusula IN
                $placeholders = implode(',', array_fill(0, count($diasIds), '?'));
                $sqlDeleteImagensDias = "DELETE FROM imagem_projeto_dia WHERE projeto_dia_id IN ({$placeholders})";
                $stmtDeleteImagensDias = $this->pdo->prepare($sqlDeleteImagensDias);
                $stmtDeleteImagensDias->execute($diasIds);
            }

            // 3. Excluir os dias do projeto
            $sqlDeleteDias = "DELETE FROM projeto_dia WHERE projeto_id = :projeto_id";
            $stmtDeleteDias = $this->pdo->prepare($sqlDeleteDias);
            $stmtDeleteDias->execute([':projeto_id' => $projetoId]);

            // 4. Excluir associações da imagem principal (capa) do projeto
            $sqlDeleteImagemCapa = "DELETE FROM imagem_projeto WHERE projeto_id = :projeto_id";
            $stmtDeleteImagemCapa = $this->pdo->prepare($sqlDeleteImagemCapa);
            $stmtDeleteImagemCapa->execute([':projeto_id' => $projetoId]);

            // 5. Excluir o projeto principal
            $sqlDeleteProjeto = "DELETE FROM projeto WHERE projeto_id = :projeto_id";
            $stmtDeleteProjeto = $this->pdo->prepare($sqlDeleteProjeto);
            $stmtDeleteProjeto->execute([':projeto_id' => $projetoId]);

            $this->pdo->commit(); // Confirma todas as exclusões
            return true;

        } catch (PDOException $e) {
            $this->pdo->rollBack(); // Desfaz tudo em caso de erro
            error_log("Erro ao excluir projeto completo [ID: {$projetoId}]: " . $e->getMessage());
            return false;
        }
    }
}