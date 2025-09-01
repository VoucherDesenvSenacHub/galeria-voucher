<?php
/**
 * Componente de navegação por abas para páginas de turmas
 * 
 * @param string $currentTab - A aba atual ('dados-gerais', 'projetos', 'docentes', 'alunos')
 * @param int|null $turmaId - ID da turma (opcional, usado para manter o contexto nas navegações)
 */
function tabsTurmaComponent($currentTab = 'Dados-gerais', $turmaId = null) {
    // Constrói o parâmetro de ID para as URLs
    $idParam = $turmaId ? "?id=" . $turmaId : '';
    
    // Array com as abas disponíveis
    $tabs = [
        'Dados-gerais' => [
            'url' => 'cadastroTurmas.php' . $idParam,
            'label' => 'DADOS GERAIS'
        ],
        'Projetos' => [
            'url' => 'CadastroProjetos.php' . $idParam,
            'label' => 'PROJETOS'
        ],
        'Docentes' => [
            'url' => 'docentes.php' . $idParam,
            'label' => 'DOCENTES'
        ],
        'Alunos' => [
            'url' => 'alunos.php' . $idParam,
            'label' => 'ALUNOS'
        ]
    ];
    
    echo '<div class="tabs-adm-turmas">';
    
    foreach ($tabs as $tabKey => $tabInfo) {
        $activeClass = ($currentTab === $tabKey) ? 'active' : '';
        echo '<a class="tab-adm-turmas ' . $activeClass . '" href="' . $tabInfo['url'] . '">' . $tabInfo['label'] . '</a>';
    }
    
    echo '</div>';
}
?>
