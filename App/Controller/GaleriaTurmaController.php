<?php
require_once __DIR__ ."/BaseController.php";
require_once __DIR__ ."/../Model/AlunoModel.php";
require_once __DIR__ ."/../Model/TurmaModel.php";
require_once __DIR__ ."/../Model/ProjetoModel.php";
require_once __DIR__ ."/../Model/DocenteModel.php";

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
        switch ($_SERVER['REQUEST_METHOD']) {
            case 'GET':
                $this->carregarDadosTurma();
                break;
            default:
                $this->gerenciarMetodosNaoPermitidos();
                break;
        }
    }

    private function verificarIdNaUrl(): int {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            $this->toJson(["erro" => "Parâmtro inválido para turma id"], 400);
        }

        return intval($_GET['id']);
    }

    /**
     * Carrega dados completos da turma com seus projetos, alunos e orientadores,
     * formatando-os para uso na view.
     *
     * @return array
     */
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

        // Funções auxiliares como urlImagem e formatarProjetos devem continuar em helpers
        // VARIAVEIS["DIR_IMG"] . 'utilitarios/foto.png';

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