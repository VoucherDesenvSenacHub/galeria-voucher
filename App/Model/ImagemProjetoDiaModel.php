<?php
class ImagemProjetoDiaModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

    public function buscarPorProjetoDia(int $projetoDiaId): array
    {
        $sql = "SELECT ipd.url 
                FROM imagem_projeto_dia ipd
                WHERE ipd.projeto_dia_id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $projetoDiaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
