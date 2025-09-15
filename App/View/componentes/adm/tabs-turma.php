<?php
/**
 * Componente de navegação por abas para páginas de turmas
 * * @param string $currentTab - A aba atual ('dados-gerais', 'projetos', 'docentes', 'alunos')
 * @param int|null $turmaId - ID da turma (opcional, usado para manter o contexto nas navegações)
 */
function tabsTurmaComponent($currentTab = 'dados-gerais', $turmaId = null) {
    // Constrói o parâmetro de ID para as URLs
    $idParam = $turmaId ? "?id=" . $turmaId : '';
    $isDisabled = is_null($turmaId); // Desabilita as abas se não houver ID de turma

    $arquivoAtual = basename($_SERVER['PHP_SELF'], '.php');

    switch ($arquivoAtual) {
        case 'cadastroTurmas':
            $currentTab = 'dados-gerais';
            break;
        case 'CadastroProjetos':
            $currentTab = 'projetos';
            break;
        case 'docentes':
            $currentTab = 'docentes';
            break;
        case 'alunos':
            $currentTab = 'alunos';
            break;
        default:
            $currentTab = 'dados-gerais';
            break;
    }

    // Array com as abas disponíveis
    $tabs = [
        'dados-gerais' => [
            'url' => 'cadastroTurmas.php' . $idParam,
            'label' => 'DADOS GERAIS',
            'disabled' => false
        ],
        'projetos' => [
            'url' => $isDisabled ? '#' : 'CadastroProjetos.php' . $idParam,
            'label' => 'PROJETOS',
            'disabled' => $isDisabled
        ],
        'docentes' => [
            'url' => $isDisabled ? '#' : 'docentes.php' . $idParam,
            'label' => 'DOCENTES',
            'disabled' => $isDisabled
        ],
        'alunos' => [
            'url' => $isDisabled ? '#' : 'alunos.php' . $idParam,
            'label' => 'ALUNOS',
            'disabled' => $isDisabled
        ]
    ];
    
    echo '<div class="tabs-adm-turmas">';
    
    foreach ($tabs as $tabKey => $tabInfo) {
        $activeClass = ($currentTab === $tabKey) ? 'active' : '';
        $disabledClass = $tabInfo['disabled'] ? 'disabled' : '';
        echo '<a class="tab-adm-turmas ' . $activeClass . ' ' . $disabledClass . '" href="' . $tabInfo['url'] . '">' . $tabInfo['label'] . '</a>';
    }
    
    echo '</div>';
}
?>