<?php

require_once __DIR__ . '/BaseModel.php';

class TurmaModel extends BaseModel
{
    public static $tabela = "turma";

    public function __construct()
    {
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
                INSERT INTO " . self::$tabela . " 
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

    public function buscarTodasTurmasComPolo(): array
    {
        try {
            $query = "
                SELECT 
                    t.turma_id,
                    t.nome AS NOME_TURMA,
                    p.nome AS NOME_POLO
                FROM " . self::$tabela . " t
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

    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
            // Recebendo os dados do formulário
            $nome = trim($_POST['nome'] ?? '');
            $descricao = trim($_POST['descricao'] ?? '');
            $data_inicio = $_POST['data_inicio'] ?? '';
            $data_fim = !empty($_POST['data_fim']) ? $_POST['data_fim'] : null;
            $polo_nome = trim($_POST['polo'] ?? '');
            $imagem_id = null; // Placeholder para o ID da imagem

            $erros = [];
            if (empty($nome)) $erros[] = "O campo 'Nome' é obrigatório.";
            if (empty($data_inicio)) $erros[] = "A 'Data de Início' é obrigatória.";
            if (empty($polo_nome)) $erros[] = "O campo 'Polo' é obrigatório.";
            
            // Validação de datas
            if (!empty($data_fim) && $data_fim < $data_inicio) {
                $erros[] = "A data de fim não pode ser anterior à data de início.";
            }

            // Futuramente, aqui será o código para tratar o upload da imagem
            if (isset($_FILES['imagem_turma']) && $_FILES['imagem_turma']['error'] == 0) {
                // Lógica para salvar a imagem e obter o ID para a variável $imagem_id
            }
            
            // Em um sistema real, o ID do polo seria buscado no banco.
            $polo_id = 1; // Exemplo: ID do 'SENAC Centro'

            if (!empty($erros)) {
                $_SESSION['erros_turma'] = $erros;
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }

            $turmaModel = new TurmaModel();
            $resultado = $turmaModel->criarTurma($nome, $descricao, $data_inicio, $data_fim, $polo_id, $imagem_id);

            if ($resultado) {
                $_SESSION['sucesso_turma'] = "Turma cadastrada com sucesso!";
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                exit;
            } else {
                $_SESSION['erros_turma'] = ["Ocorreu um erro ao salvar a turma. Tente novamente."];
                header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                exit;
            }
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
    public function buscarTurmaPorId(int $id)
    {
        $query = "SELECT * FROM turma WHERE turma_id = :id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Busca todas as turmas com o nome do respectivo polo, ordenadas alfabeticamente.
     * @return array
     */
    /**
     * MÉTODO ADICIONADO: Busca todas as turmas e o nome do polo associado.
     *
     * @return array Retorna uma lista de turmas com os nomes dos polos.
     */
    

}