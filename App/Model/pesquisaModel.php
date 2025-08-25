<?php

require_once __DIR__ . "/BaseModel.php";

class PesquisaModel extends BaseModel
{
    protected $tabela = 'turma';

    public function __construct()
    {
        parent::__construct();
    }


    public function buscarAlunosSemVinculo(){
        try{
            //busca e retorna os alunos que não tem vinculo com nenhuma turma.
            $query = "SELECT pessoa.nome,pessoa.email, pessoa.linkedin,pessoa.github 
            FROM pessoa WHERE perfil = 'aluno' AND NOT EXISTS (SELECT 1 FROM aluno_turma WHERE aluno_turma.pessoa_id = pessoa.pessoa_id);";

            $stmt = $this->pdo->prepare($query);
            $stmt->execute();
            var_dump ($stmt->fetchAll(PDO::FETCH_ASSOC));
        }
        catch(PDOException $e){
            error_log("Erro ao buscar alunos sem vínculo: " . $e->getMessage());
            var_dump( ["DEU ERRADO"]);
        }


    }
}
$turmaModel = new PesquisaModel();
$funcao = $turmaModel->buscarAlunosSemVinculo();