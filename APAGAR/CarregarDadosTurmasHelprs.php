<?php

/**
 * Carrega os dados completos de uma turma pelo seu ID, incluindo projetos, alunos e orientadores,
 * além de formatar informações para exibição.
 * 
 * @param int $turmaId ID da turma para buscar os dados.
 * @return array|null Retorna um array associativo com os dados formatados da turma ou null se não encontrada.
 * 
 * Estrutura do array retornado:
 * [
 *   'imagemTurmaUrl' => string,        // URL da imagem da turma (ou fallback)
 *   'nomeTurma' => string,             // Nome da turma, escapado para HTML
 *   'descricaoTurma' => string,        // Descrição da turma formatada em HTML (nl2br + htmlspecialchars)
 *   'alunos' => array,                 // Lista de alunos da turma
 *   'orientadores' => array,           // Lista de docentes/orientadores da turma
 *   'tabsProjetos' => array,           // Tabs dos projetos formatados
 *   'projetosFormatados' => array      // Projetos formatados para exibição
 * ]
 */

function carregarDadosTurma(int $turmaId): ?array
{
    $turmaModel = new TurmaModel();
    $turma = $turmaModel->buscarPorId($turmaId);

    if (!$turma) {
        return null; // turma não existe
    }

    $projetoModel = new ProjetoModel();
    $projetos = $projetoModel->buscarProjetosPorTurma($turmaId);

    $alunoModel = new AlunoModel();
    $alunos = $alunoModel->buscarPorTurma($turmaId);

    $docenteModel = new DocenteModel();
    $orientadores = $docenteModel->buscarPorTurma($turmaId);

    $imagemTurmaUrl = urlImagem($turma['imagem'], 'turmas/', 'turma-galeria.png');
    $nomeTurma = htmlspecialchars($turma['nome']);
    $descricaoTurma = nl2br(htmlspecialchars($turma['descricao']));

    $dadosProjetos = formatarProjetos($projetos, $projetoModel);

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
