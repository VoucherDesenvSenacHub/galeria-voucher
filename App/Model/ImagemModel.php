<?php
require_once __DIR__ . '/BaseModel.php';

class ImagemModel extends BaseModel {

    // Criar imagem
    public function criarImagem(?string $url, ?string $text, ?string $descricao): int {
        // Se não passou URL ou está vazio, usa a imagem padrão
        if (empty($url)) {
            $url = 'App/View/assets/img/utilitarios/avatar.png';
        }
    
        $sql = "INSERT INTO imagem (url, text, descricao, data_upload)
                VALUES (:url, :text, :descricao, NOW())";
    
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':url' => $url,
            ':text' => $text,
            ':descricao' => $descricao
        ]);
    


        return (int)$this->pdo->lastInsertId(); // Retorna o ID da imagem criada
    }
 
    

    // Buscar imagem por ID
    public function buscarImagemPorId(int $id): ?array {
        $sql = "SELECT * FROM imagem WHERE imagem_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $imagem = $stmt->fetch(PDO::FETCH_ASSOC);

        return $imagem ?: null;
    }

    // Buscar imagem por URL
    public function buscarImagemPorUrl(string $url): ?array {
        $sql = "SELECT * FROM imagem WHERE url = :url";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':url' => $url]);
        $imagem = $stmt->fetch(PDO::FETCH_ASSOC);

        return $imagem ?: null;
    }

    // Listar todas as imagens
    public function listarImagens(): array {
        $sql = "SELECT * FROM imagem ORDER BY data_upload DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Deletar imagem (opcional, com cuidado se ela estiver sendo usada por uma pessoa)
    public function deletarImagem(int $id): bool {
        $sql = "DELETE FROM imagem WHERE imagem_id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
