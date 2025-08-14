<!-- Atualizar o model para pesquisar o docente por nome, ver a pagina 'editar-turma.php' se vai ser necessario criar, e/ou já é algo criado
     
        -->

<?php

require_once __DIR__ . "/BaseModel.php";

class DocenteModel extends BaseModel {

    public function __construct() {
        parent::__construct();
    }

    /**
     * Busca todos os docentes com seus respectivos polos.
     * @return array
     */
    public function buscarTodosDocentesComPolo(): array
    {
        $query = "
            SELECT 
                p.nome,
                polo.nome AS polo
            FROM 
                pessoa p
            JOIN 
                docente_turma dt ON p.pessoa_id = dt.pessoa_id
            JOIN 
                turma t ON dt.turma_id = t.turma_id
            JOIN
                polo ON t.polo_id = polo.polo_id
            WHERE
                p.perfil = 'professor'
            GROUP BY
                p.pessoa_id
            ORDER BY 
                p.nome ASC
        ";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function PesquisarDocente($nome)
    {
        $query = "SELECT p.nome 
                  FROM pessoa p 
                  where nome LIKE :nome and p.perfil = 'professor'";
        
        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':nome', "'%" .  $nome . "%'" );

        $stmt->execute();

    }
}