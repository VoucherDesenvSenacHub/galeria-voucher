<?php

require_once __DIR__ . '/ImageHelper.php';

/**
 * Formata os dados de projetos para serem exibidos na view.
 *
 * @param array $projetos Array de projetos vindo do Model.
 * @param ProjetoModel $projetoModel Instância do model de projetos.
 * @return array
 */
function formatarProjetosParaView(array $projetos, $projetoModel): array
{
    $tabsProjetos = [];
    $projetosFormatados = [];

    foreach ($projetos as $index => $projeto) {
        $tabsProjetos[] = [
            'projeto_id' => $projeto['projeto_id'],
            'nome' => $projeto['nome'],
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
                'tipo_dia' => $dia['tipo_dia'],
                'titulo' => 'Dia ' . $dia['tipo_dia'],
                'descricao' => $dia['descricao'],
                'imagens' => $imagensFormatadas,
                'ativo' => $i === 0
            ];
        }

        $projetosFormatados[] = [
            'projeto_id' => $projeto['projeto_id'],
            'nome' => $projeto['nome'],
            'descricao' => $projeto['descricao'],
            'link' => $projeto['link'],
            'dias' => $diasFormatados,
            'ativo' => $index === 0
        ];
    }

    return [
        'tabsProjetos' => $tabsProjetos,
        'projetosFormatados' => $projetosFormatados
    ];
}