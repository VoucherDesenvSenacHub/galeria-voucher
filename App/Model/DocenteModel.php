<?php
class DocenteModel extends BaseModel
{
    public static $tabela = "docente";

    public function __construct()
    {
        parent::__construct();
    }

    public function buscarPorTurma(int $turmaId): array
    {
        $sql = "SELECT p.*, i.url AS imagem 
                FROM docente_turma dt
                INNER JOIN pessoa p ON dt.pessoa_id = p.pessoa_id
                LEFT JOIN imagem i ON p.imagem_id = i.imagem_id
                WHERE dt.turma_id = :turma_id
                ORDER BY p.nome ASC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':turma_id', $turmaId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}