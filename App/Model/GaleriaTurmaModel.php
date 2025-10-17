<?php
require_once __DIR__ ."/../Helpers/ImageHelper.php";
require_once __DIR__ ."/AlunoModel.php";
require_once __DIR__ ."/TurmaModel.php";
require_once __DIR__ ."/ProjetoModel.php";
require_once __DIR__ ."/DocenteModel.php";

class GaleriaTurmaModel
{
    private TurmaModel $turmaModel;
    private ProjetoModel $projetoModel;
    private AlunoModel $alunoModel;
    private DocenteModel $docenteModel;

    public function __construct()
    {
        $this->turmaModel = new TurmaModel();
        $this->projetoModel = new ProjetoModel();
        $this->alunoModel = new AlunoModel();
        $this->docenteModel = new DocenteModel();
    }

    public function carregarDadosTurma(int $turmaId): ?array
    {
        $turma = $this->turmaModel->buscarPorId($turmaId);
        
        if (!$turma || empty($turma)) {
            return null;
        }

        $projetos = $this->projetoModel->buscarProjetosPorTurma($turmaId);
        $alunos = $this->alunoModel->buscarPorTurma($turmaId);
        $orientadores = $this->docenteModel->buscarPorTurma($turmaId);

        return [
            'imagemTurmaUrl' => urlImagem($turma['imagem'], 'App/View/assets/img/utilitarios/foto.png'),
            'nomeTurma' => $turma['nome'],
            'descricaoTurma' => $turma['descricao'],
            'alunos' => $alunos,
            'orientadores' => $orientadores,
            'projetos' => $projetos, // Agora envia os dados brutos
            "polo" => $turma["polo"],
            "cidade"=> $turma["cidade"],
        ];
    }
}