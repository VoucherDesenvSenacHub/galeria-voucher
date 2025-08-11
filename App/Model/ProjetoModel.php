<?php
require_once __DIR__ . "/BaseModel.php";
require_once __DIR__ . "/ImagemProjetoDiaModel.php"; // <-- ESSENCIAL

class ProjetoModel extends BaseModel
{
    
    public function __construct()
    {
        $this->tabela = "projeto";
        parent::__construct();
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

        $imagemProjetoDiaModel = new ImagemProjetoDiaModel();
        foreach ($dias as &$dia) {
            // Use a chave correta conforme o banco
            $dia['id'] = $dia['projeto_dia_id'];
            $dia['imagens'] = $imagemProjetoDiaModel->buscarPorProjetoDia($dia['projeto_dia_id']);
        }
        return $dias;
    }

}
