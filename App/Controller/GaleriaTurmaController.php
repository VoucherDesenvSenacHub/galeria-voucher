<?php

class GaleriaTurmaController
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

    public function verificarIdNaUrl(): int {
        if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
            header("Location: ./turma.php");
            exit();
        }

        return intval($_GET['id']);
    }

    /**
     * Carrega dados completos da turma com seus projetos, alunos e orientadores,
     * formatando-os para uso na view.
     *
     * @param int $turmaId
     * @return array
     */
    public function carregarDadosTurma(int $turmaId): array
    {
        $turma = $this->turmaModel->buscarPorId($turmaId);
        
        if (!$turma || empty($turma)) {
            header("Location: ./turma.php");
            exit();
        }

        $projetos = $this->projetoModel->buscarProjetosPorTurma($turmaId);
        $alunos = $this->alunoModel->buscarPorTurma($turmaId);
        $orientadores = $this->docenteModel->buscarPorTurma($turmaId);

        // Funções auxiliares como urlImagem e formatarProjetos devem continuar em helpers
        $imagemTurmaUrl = $turma['imagem'] ?? VARIAVEIS["DIR_IMG"] . 'utilitarios/foto.png';
        $nomeTurma = htmlspecialchars($turma['nome']);
        $descricaoTurma = nl2br(htmlspecialchars($turma['descricao']));

        $dadosProjetos = formatarProjetos($projetos, $this->projetoModel);

        return [
            'imagemTurmaUrl' => $imagemTurmaUrl,
            'nomeTurma' => $nomeTurma,
            'descricaoTurma' => $descricaoTurma,
            'alunos' => $alunos,
            'orientadores' => $orientadores,
            'tabsProjetos' => $dadosProjetos['tabsProjetos'],
            'projetosFormatados' => $dadosProjetos['projetosFormatados'],
            "polo" => $turma["polo"],
            "cidade"=> $turma["cidade"],
        ];
    }
}