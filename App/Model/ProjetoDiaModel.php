<?php
class ProjetoDiaModel {
    private PDO $pdo;

    public function __construct() {
        $this->pdo = Database::conectar();
    }

    public function buscarDiasPorProjeto(int $projetoId): array {
        $sql = "
            SELECT pd.*, ipd.caminho AS imagem
            FROM projeto_dia pd
            LEFT JOIN imagem_projeto_dia ipd ON ipd.projeto_dia_id = pd.id
            WHERE pd.projeto_id = :projetoId
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':projetoId', $projetoId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
