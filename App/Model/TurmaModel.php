<?php

require_once __DIR__ . "/BaseModel.php";

class TurmaModel extends BaseModel
{

    public function __construct()
    {
        parent::__construct();
    }

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

    /**
     * Busca todas as turmas com o nome do respectivo polo, ordenadas alfabeticamente.
     * @return array
     */
    public function buscarTodasTurmasComPolo(): array
    {
        $query = "
            SELECT 
                t.turma_id,
                t.nome AS NOME_TURMA,
                p.nome AS NOME_POLO
            FROM 
                turma t
            JOIN 
                polo p ON t.polo_id = p.polo_id
            ORDER BY 
                t.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function BuscarProjetosComDescricao()
    {
        $query = "
            SELECT 
                pr.projeto_id,
                pr.nome AS NOME_PROJETO,
                pr.descricao AS DESCRICAO_PROJETO,
                pr.link AS LINK_PROJETO,
                t.nome AS NOME_TURMA,
                p.nome AS NOME_POLO,
                i.url AS URL_IMAGEM,
                i.descricao AS DESCRICAO_IMAGEM
            FROM 
                projeto pr
            JOIN 
                turma t ON pr.turma_id = t.turma_id
            JOIN 
                polo p ON t.polo_id = p.polo_id
            LEFT JOIN 
                imagem_projeto ip ON pr.projeto_id = ip.projeto_id
            LEFT JOIN 
                imagem i ON ip.imagem_id = i.imagem_id
            ORDER BY 
                pr.nome ASC
        ";
    
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}
