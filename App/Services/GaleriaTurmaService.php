<?php
namespace App\Services;

use App\Model\TurmaModel;
use App\Model\ProjetoModel;
use App\Model\AlunoModel;
use App\Model\DocenteModel;

class GaleriaTurmaService {

    private TurmaModel $turmaModel;
    private ProjetoModel $projetoModel;
    private AlunoModel $alunoModel;
    private DocenteModel $docenteModel;
    private array|null $turmas;
    private int $idTurma;

    public function __construct(TurmaModel $turmaModel, ProjetoModel $projetoModel, AlunoModel $alunoModel, DocenteModel $docenteModel)
    {
        $this->turmaModel = $turmaModel;
        $this->projetoModel = $projetoModel;
        $this->alunoModel = $alunoModel;
        $this->docenteModel = $docenteModel;
    }


    public function buscarIdUrl()
    {
        if (!isset($_GET['turma_id'])) {
            header("Location: galeria-turma.php");
            exit;
        }


    }

    public function validaIdTurma(int $id)
    {
        $this->turmas = $this->turmaModel->buscarPorId($id);

        if($this->turmas)return

        header("Location: /turmas");
        exit;
    }

    public function buscarDados(int $id): array
    {
        $projetos = $this->projetoModel->buscarProjetosPorTurma($id);
        $alunos = $this->alunoModel->buscarPorTurma($id);
        $docentes = $this->docenteModel->buscarPorTurma($id);

        return [
            "turmas" => $this->turmas,
            "projetos" => $projetos,
            "alunos" => $alunos,
            "docentes" => $docentes,
        ];
    }
}