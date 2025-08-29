<?php

require_once __DIR__ . '/ImageHelper.php';

/**
 * Formata os dados dos projetos para uso na view, preparando tabs, dias e imagens.
 * 
 * Para cada projeto, busca os dias associados e formata os dados, escapando strings
 * para evitar problemas de segurança, e organiza as informações para facilitar a renderização.
 * 
 * @param array $projetos Array bruto de projetos vindos do banco ou model.
 * @param object $projetoModel Instância do model que permite buscar os dias de cada projeto.
 * @return array Retorna um array associativo contendo:
 *               - 'tabsProjetos': array com dados das abas dos projetos para navegação.
 *               - 'projetosFormatados': array com dados completos dos projetos formatados para exibição.
 */

function formatarProjetos(array $projetos, $projetoModel): array {
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
