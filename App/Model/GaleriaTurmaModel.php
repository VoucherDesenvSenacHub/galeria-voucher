<?php
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


    /**
     * Carrega dados completos da turma com seus projetos, alunos e orientadores,
     * formatando-os para uso na view.
     *
     * @return array
     */
    public function carregarDadosTurma(int $turmaId): array | null
    {
        $turma = $this->turmaModel->buscarPorId($turmaId);
        
        if (!$turma || empty($turma)) {
            return null;
        }

        $projetos = $this->projetoModel->buscarProjetosPorTurma($turmaId);
        $alunos = $this->alunoModel->buscarPorTurma($turmaId);
        $orientadores = $this->docenteModel->buscarPorTurma($turmaId);

        $dadosProjetos = $this->formatarProjetos($projetos, $this->projetoModel);

        // Funções auxiliares como urlImagem e formatarProjetos devem continuar em helpers
        // VARIAVEIS["DIR_IMG"] . 'utilitarios/foto.png';

        return [
            'imagemTurmaUrl' => urlImagem($turma['imagem'],  'App/View/assets/img/utilitarios/foto.png'),
            'nomeTurma' => $turma['nome'],
            'descricaoTurma' => $turma['descricao'],
            'alunos' => $alunos,
            'orientadores' => $orientadores,
            'tabsProjetos' => $dadosProjetos['tabsProjetos'],
            'projetosFormatados' => $dadosProjetos['projetosFormatados'],
            "polo" => $turma["polo"],
            "cidade"=> $turma["cidade"],
        ];
    }

    private function formatarProjetos(array $projetos, $projetoModel): array {
        $tabsProjetos = [];
        $projetosFormatados = [];

        foreach ($projetos as $index => $projeto) {
            $tabsProjetos[] = [
                'projeto_id' => $projeto['projeto_id'],
                'nome' => htmlspecialchars($projeto['nome']),
                'classe_css' => $index === 0 ? 'active' : ''
            ];

            $dias = $projetoModel->buscarDiasProjeto($projeto['projeto_id']);
            $diasFormatados = [];

            foreach ($dias as $i => $dia) {
                $imagensFormatadas = array_map(function ($img) {
                    return [
                        'url' => urlImagem($img['url']),
                        'alt' => 'Imagem do projeto'
                    ];
                }, $dia['imagens']);

                $diasFormatados[] = [
                    'id' => $dia['id'],
                    'tipo_dia' => htmlspecialchars($dia['tipo_dia']),
                    'titulo' => 'Dia ' . htmlspecialchars($dia['tipo_dia']),
                    'descricao' => nl2br(htmlspecialchars($dia['descricao'])),
                    'linkProjeto' => $dia['linkProjeto'] ?? null,
                    'imagens' => $imagensFormatadas,
                    'ativo' => $i === 0
                ];
            }

            $projetosFormatados[] = [
                'projeto_id' => $projeto['projeto_id'],
                'nome' => htmlspecialchars($projeto['nome']),
                'descricao' => nl2br(htmlspecialchars($projeto['descricao'])),
                'link' => htmlspecialchars($projeto['link']),
                // Compatibilidade com helpers de renderização que esperam 'linkProjeto'
                'linkProjeto' => htmlspecialchars($projeto['link']),
                'dias' => $diasFormatados,
                'ativo' => $index === 0
            ];
        }

        return [
            'tabsProjetos' => $tabsProjetos,
            'projetosFormatados' => $projetosFormatados
        ];
    }
}