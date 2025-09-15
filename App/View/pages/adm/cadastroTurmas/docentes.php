<?php

$paginaAtiva = 'turmas';

// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../../Config/env.php";

// VERIFICAÇÃO DE ACESSO PARA O USUARiO NÃO ACESSAR A PAGINA DIRETO DA URL
if (!isset($_GET['id']) || empty($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
    exit;
}


require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../../Service/AuthService.php";
require_once __DIR__ . "/../../../../Model/DocenteModel.php";
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";
require_once __DIR__ . "/../../../componentes/BreadCrumbs.php";

headerComponent("Voucher Desenvolvedor - Docentes");
$currentTab = 'Docentes';

// 2. LÓGICA DE BUSCA DE DADOS
$docentes = [];
$isEditMode = false;
$turmaId = null;

try {
    $docenteModel = new DocenteModel();

    // Verifica se o ID da turma foi passado (modo edição)
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $turmaId = (int) $_GET['id'];

        if ($turmaId > 0) {
            $isEditMode = true;
            $docentes = $docenteModel->buscarDocentesPorTurmaId($turmaId);
        }
    }
    // Se não houver ID, está no modo cadastro (não é erro)

} catch (Exception $e) {
    // Em caso de erro, define $docentes como um array vazio e loga o erro
    $docentes = [];
    error_log("Erro ao buscar docentes: " . $e->getMessage());

    // Exibe mensagem de erro para o usuário apenas se estiver no modo edição
    if ($isEditMode) {
        $error_message = "Erro ao carregar docentes: " . $e->getMessage();
    }
}

// Verifica se o usuário logado é um administrador para exibir o botão de excluir
$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';

?>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="body-adm">
    <div class="container-adm">
        <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>

        <?php
        $isAdmin = true;
        require_once __DIR__ . "/../../../componentes/nav.php";
        ?>

        <main class="main-turmas-turmas">
            <?php BreadCrumbs::gerarBreadCrumbs()?>
            <?php
            // Usa o componente de abas das turmas
            tabsTurmaComponent($currentTab, $turmaId);
            ?>

            <?php if (isset($error_message)): ?>
                <div class="error-message">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <div class="topo-lista-alunos">
                <?php
                buttonComponent('primary', 'VINCULAR DOCENTE', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('professor')\"");
                ?>

                <div class="input-pesquisa-container">
                    <input type="text" id="pesquisa" placeholder="Pesquisar por nome ou polo">
                    <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/lupa.png" alt="Ícone de lupa"
                        class="icone-lupa-img">
                </div>
            </div>

            <div class="tabela-principal-lista-alunos">
                <div class="tabela-container-lista-alunos">
                    <table id="tabela-alunos">
                        <thead>
                            <tr>
                                <th>NOME</th>
                                <th>POLO</th>
                                <th>AÇÕES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($docentes)): ?>
                                <?php foreach ($docentes as $docente): ?>
                                    <tr data-pessoa-id="<?= $docente['pessoa_id'] ?>" data-turma-id="<?= $turmaId ?>">
                                        <td><?= htmlspecialchars($docente['nome']) ?></td>
                                        <td><?= htmlspecialchars($docente['polo']) ?></td>
                                        <td class="acoes">
                                            <?php if ($is_admin): ?>
                                                <span class="material-symbols-outlined acao-delete" title="Desvincular docente"
                                                    onclick="confirmarDesvinculacao(<?= $docente['pessoa_id'] ?>, <?= $turmaId ?>, '<?= htmlspecialchars($docente['nome']) ?>')">delete</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            
                            <!-- Linha de estado vazio (sempre presente, mas oculta quando há docentes) -->
                            <tr id="empty-state-row" style="<?= !empty($docentes) ? 'display: none;' : '' ?>">
                                <td colspan="3" class="empty-table-cell">
                                    <div class="empty-state-container">
                                        <p class="empty-state-title">Nenhum docente vinculado a esta turma.</p>
                                        <p class="empty-state-description">Clique em "VINCULAR DOCENTE" para adicionar docentes à turma.</p>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <section class="section_modal"></section>
        </main>
    </div>

    <script src="../../../assets/js/adm/lista-alunos.js"></script>
    <script src="../../../assets/js/main.js"></script>
    <script src="../../../assets/js/adm/autocomplete-pessoas.js"></script>
    <script src="../../../assets/js/adm/desvincula-docente.js"></script>

</body>

</html>