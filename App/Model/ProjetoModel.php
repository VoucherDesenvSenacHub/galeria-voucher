<?php
class ProjetoModel
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::conectar();
    }

    public function buscarProjetosPorTurma(int $turmaId): array
    {
        $sql = "SELECT * FROM projeto WHERE turma_id = :turma_id";
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

        // Para cada dia, buscar as imagens
        $imagemProjetoDiaModel = new ImagemProjetoDiaModel();
        foreach ($dias as &$dia) {
            $dia['id'] = $dia['projeto_dia_id'];
            $dia['imagens'] = $imagemProjetoDiaModel->buscarPorProjetoDia($dia['projeto_dia_id']);
        }
        return $dias;
    }
}
