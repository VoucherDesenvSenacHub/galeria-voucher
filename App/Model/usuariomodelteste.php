<?php
require_once __DIR__ . '/BaseModel.php';

class UsuarioModelTeste extends BaseModel
{
    public function listar(): array
    {
        $sql = "SELECT DISTINCT
                    p.nome,
                    p.perfil AS tipo,
                    po.nome AS polo
                FROM pessoa p
                LEFT JOIN aluno_turma at ON p.pessoa_id = at.pessoa_id
                LEFT JOIN docente_turma dt ON p.pessoa_id = dt.pessoa_id
                LEFT JOIN turma t ON t.turma_id = at.turma_id OR t.turma_id = dt.turma_id
                LEFT JOIN polo po ON po.polo_id = t.polo_id
                ORDER BY p.nome";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
