<?php
// src/Service/GaleriaTurmaService.php

class GaleriaTurmaService
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

    /**
     * Carrega dados completos da turma com seus projetos, alunos e orientadores,
     * formatando-os para uso na view.
     *
     * @param int $turmaId
     * @return array|null
     */
    public function carregarDadosTurma(int $turmaId): ?array
    {
        $turma = $this->turmaModel->buscarPorId($turmaId);
        if (!$turma) {
            return null;
        }

        $projetos = $this->projetoModel->buscarProjetosPorTurma($turmaId);
        $alunos = $this->alunoModel->buscarPorTurma($turmaId);
        $orientadores = $this->docenteModel->buscarPorTurma($turmaId);

        // Funções auxiliares como urlImagem e formatarProjetos devem continuar em helpers
        $imagemTurmaUrl = urlImagem($turma['imagem'], 'turmas/', 'turma-galeria.png');
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
        ];
    }
}
