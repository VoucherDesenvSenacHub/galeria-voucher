<?php

require_once __DIR__ . '/BaseModel.php';

class TurmaModel extends BaseModel
{
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
}