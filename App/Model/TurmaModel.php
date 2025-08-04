<?php

require_once __DIR__ . "/BaseModel.php";

class TurmaModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca todas as turmas ativas com suas respectivas imagens de capa.
     * @return array
     */
    public function buscarTurmasParaGaleria(): array
    {
        // Busca todas as turmas, procurando imagem real primeiro, senão usa padrão - QUANDO TIVER IMAGENS NO BANCO RETIRAR O COALESE
        $query = "
            SELECT 
                t.turma_id,
                t.nome AS nome_turma,
                COALESCE(i.url, 'App/View/assets/img/utilitarios/foto.png') AS imagem_url
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