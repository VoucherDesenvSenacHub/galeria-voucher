<?php
require_once __DIR__ . '/../../../Helpers/Redirect.php';
/**
 * Componente de navegação por abas para páginas de turmas
 * @param string $currentTab - A aba atual ('dados-gerais', 'projetos', 'docentes', 'alunos')
 * @param array $params - Params da url, turma_id é opcional, usado para manter o contexto nas navegações
 */
function tabsTurmaComponent($currentTab = 'dados-gerais', $params = [], ) {

    $isDisabled = is_null($params['turma_id']); // Desabilita as abas se não houver ID de turma

    $arquivoAtual = basename($_SERVER['PHP_SELF'], '.php');

    switch ($arquivoAtual) {
        case 'cadastro-turmas':
            $currentTab = 'dados-gerais';
            break;
        case 'cadastro-projetos':
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
    $queryParams = '';
    if (!empty($params)) {
        $queryParams .= '?' . http_build_query($params);
    }

    $tabs = [
        'dados-gerais' => [
            'url' => Config::get('APP_URL') . Config::get('DIR_ADM') . 'cadastro-turmas/cadastro-turmas.php' . $queryParams,
            'label' => 'DADOS GERAIS',
            'disabled' => false
        ],
        'projetos' => [
            'url' => Config::get('APP_URL') . Config::get('DIR_ADM') .'cadastro-turmas/cadastro-projetos.php' . $queryParams,
            'label' => 'PROJETOS',
            'disabled' => $isDisabled
        ],
        'docentes' => [
            'url' => Config::get('APP_URL') . Config::get('DIR_ADM') .'cadastro-turmas/docentes.php' . $queryParams,
            'label' => 'DOCENTES',
            'disabled' => $isDisabled
        ],
        'alunos' => [
            'url' => Config::get('APP_URL') . Config::get('DIR_ADM') .'cadastro-turmas/alunos.php' . $queryParams,
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