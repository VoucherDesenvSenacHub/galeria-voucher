<?php
require_once __DIR__ . '/BaseModel.php';
require_once __DIR__ . '/../Config/Config.php'; // Incluído para usar Config::get

/**
 * Classe ImagemModel
 * Responsável por todas as operações de banco de dados relacionadas à tabela 'imagem'.
 */
class ImagemModel extends BaseModel
{
    /**
     * Construtor da classe.
     * Chama o construtor da classe pai (BaseModel) para inicializar a conexão com o banco.
     */
    public function __construct()
    {
        $this->tabela = "imagem"; // Define a tabela aqui
        parent::__construct();
    }

    /**
     * Salva os dados de uma imagem no banco de dados. (Mantido para compatibilidade, mas prefira criarImagem)
     *
     * @param string $url O caminho relativo do arquivo da imagem.
     * @param string|null $descricao Uma descrição opcional para a imagem.
     * @return int|false Retorna o ID da imagem inserida ou false em caso de erro.
     */
    public function salvarImagem(string $url, ?string $descricao = null): int|false
    {
        return $this->criarImagem($url, null, $descricao);
    }

    /**
     * Cria um novo registro de imagem no banco de dados.
     *
     * @param string|null $url O caminho relativo do arquivo da imagem. Usa fallback se nulo/vazio.
     * @param string|null $text Texto alternativo ou título curto para a imagem (opcional).
     * @param string|null $descricao Descrição mais detalhada da imagem (opcional).
     * @return int|false Retorna o ID da imagem criada ou false em caso de falha.
     */
    public function criarImagem(?string $url, ?string $text, ?string $descricao): int|false
    {   
        try {

            $sql = "INSERT INTO imagem (url, text, descricao, data_upload)
                VALUES (:url, :text, :descricao, NOW())";

            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                ':url' => $url,
                ':text' => $text,
                ':descricao' => $descricao
            ]);
            return (int) $this->pdo->lastInsertId(); // Retorna o ID da imagem criada
        } catch (PDOException $e) {
            error_log("Erro ao criar imagem: " . $e->getMessage());
            throw $e;
        }
    }

    // Buscar imagem por ID
    public function buscarImagemPorId(int $id): ?array
    {
        $sql = "SELECT * FROM imagem WHERE imagem_id = :id LIMIT 1"; // Adicionado LIMIT 1
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $imagem = $stmt->fetch(PDO::FETCH_ASSOC);

        return $imagem ?: null;
    }

    // Buscar imagem por URL
    public function buscarImagemPorUrl(string $url): ?array
    {
        $sql = "SELECT * FROM imagem WHERE url = :url LIMIT 1"; // Adicionado LIMIT 1
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':url' => $url]);
        $imagem = $stmt->fetch(PDO::FETCH_ASSOC);

        return $imagem ?: null;
    }

    // Listar todas as imagens
    public function listarImagens(): array
    {
        $sql = "SELECT * FROM imagem ORDER BY data_upload DESC";
        $stmt = $this->pdo->query($sql); // Pode usar query() para selects simples sem parâmetros
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Deleta uma imagem do banco de dados.
     * CUIDADO: Não deleta o arquivo físico. Verifique as dependências antes de usar.
     *
     * @param int $id O ID da imagem a ser deletada.
     * @return bool True se a exclusão foi bem-sucedida, false caso contrário.
     */
    public function deletarImagem(int $id): bool
    {
        // Antes de deletar, seria ideal verificar se a imagem não está sendo usada
        // (ex: em tabelas pessoa, turma, imagem_projeto_dia).
        // Esta verificação não está implementada aqui por simplicidade.

        $sql = "DELETE FROM imagem WHERE imagem_id = :id";
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            // Captura erro de chave estrangeira se a imagem estiver em uso
            error_log("Erro ao deletar imagem ID {$id}: " . $e->getMessage());
            return false;
        }

    }
}
