<?php
require_once __DIR__ . "/BaseModel.php";

class ImagemProjetoDiaModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

    public function buscarPorProjetoDia(int $projetoDiaId): array
    {
        $sql = "SELECT ipd.*, i.caminho AS imagem
                FROM imagem_projeto_dia ipd
                INNER JOIN imagem i ON i.imagem_id = ipd.imagem_id
                WHERE ipd.projeto_dia_id = :projeto_dia_id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':projeto_dia_id', $projetoDiaId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
