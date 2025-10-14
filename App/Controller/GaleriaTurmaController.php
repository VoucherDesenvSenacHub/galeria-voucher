<?php
require_once __DIR__ ."/BaseController.php";
require_once __DIR__ ."/../Model/AlunoModel.php";
require_once __DIR__ ."/../Model/TurmaModel.php";
require_once __DIR__ ."/../Model/ProjetoModel.php";
require_once __DIR__ ."/../Model/DocenteModel.php";
require_once __DIR__ . '/../Helpers/Request.php';

class GaleriaTurmaController extends BaseController
{
    protected array $metodosPermitidos = ["GET"];
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

    public function gerenciarRequisicao(): void
    {
        switch (Request::getMethod()) {
            case 'GET':
                $this->carregarDadosTurma();
                break;
            default:
                $this->gerenciarMetodosNaoPermitidos();
                break;
        }
    }

    private function verificarIdNaUrl(): int
    {
        $id = Request::getUriId();
        if ($id === null) {
            $this->toJson(["erro" => "Parâmetro inválido para turma id"], 400);
        }
        return $id;
    }

    private function carregarDadosTurma()
    {
        $turmaId = $this->verificarIdNaUrl();
        $turma = $this->turmaModel->buscarPorId($turmaId);
        
        if (!$turma || empty($turma)) {
            $this->toJson(["erro" => "Turma não encontrada"], 422);
        }

        $projetos = $this->projetoModel->buscarProjetosPorTurma($turmaId);
        $alunos = $this->alunoModel->buscarPorTurma($turmaId);
        $orientadores = $this->docenteModel->buscarPorTurma($turmaId);

        $this->toJson([
            'imagemTurmaUrl' => $turma['imagem'],
            'nomeTurma' => $turma['nome'],
            'descricaoTurma' => $turma['descricao'],
            'alunos' => $alunos,
            'orientadores' => $orientadores,
            'projetos' => $projetos,
            "polo" => $turma["polo"],
            "cidade"=> $turma["cidade"],
        ]);
    }
}

$controller = new GaleriaTurmaController();
$controller->gerenciarRequisicao();