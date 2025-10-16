<?php
$paginaAtiva = 'turmas';

// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../../Config/App.php";
require_once __DIR__ . "/../../../../Helpers/Redirect.php"; // <--- ADICIONADO AQUI

// VERIFICAÇÃO DE ACESSO
if (!isset($_GET['id']) || empty($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    Redirect::toAdm('listaTurmas.php'); // Usando a classe Redirect
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
$turmaId = (int)$_GET['id'];

try {
    $docenteModel = new DocenteModel();
    $docentes = $docenteModel->buscarDocentesPorTurmaId($turmaId);
} catch (Exception $e) {
    error_log("Erro ao buscar docentes: " . $e->getMessage());
    $error_message = "Erro ao carregar docentes.";
}

$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';
?>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="layout body-adm">
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../../componentes/nav.php";
    ?>

    <main class="layout-main main-turmas-turmas">
        <?php BreadCrumbs::gerarBreadCrumbs() ?>
        <?php tabsTurmaComponent($currentTab, $turmaId); ?>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>
        <?php if (isset($_SESSION['erro'])): ?>
            <div class="error-message"><?= htmlspecialchars($_SESSION['erro']) ?></div>
            <?php unset($_SESSION['erro']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['sucesso'])): ?>
            <div class="success-message"><?= htmlspecialchars($_SESSION['sucesso']) ?></div>
            <?php unset($_SESSION['sucesso']); ?>
        <?php endif; ?>

        <div class="topo-lista-alunos">
            <?php buttonComponent('primary', 'VINCULAR DOCENTE', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('professor', " . $turmaId . ")\""); ?>
            <div class="input-pesquisa-container">
                <input type="text" id="pesquisa" placeholder="Pesquisar por nome ou polo">
                <img src="<?= Config::get('APP_URL') . Config::get('DIR_IMG') ?>adm/lupa.png" alt="Ícone de lupa" class="icone-lupa-img">
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
                                                onclick="confirmarDesvinculacao(<?= $docente['pessoa_id'] ?>, <?= $turmaId ?>, '<?= htmlspecialchars(addslashes($docente['nome'])) ?>')">delete</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <tr id="empty-state-row" style="<?= !empty($docentes) ? 'display: none;' : '' ?>">
                            <td colspan="3" class="empty-table-cell">
                                <div class="empty-state-container">
                                    <p class="empty-state-title">Nenhum docente vinculado a esta turma.</p>
                                    <p class="empty-state-description">Clique em "VINCULAR DOCENTE" para adicionar.</p>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <section class="section_modal"></section>
    </main>

    <script src="<?= Config::get('APP_URL') ?>App/View/assets/js/adm/lista-alunos.js"></script>
    <script src="<?= Config::get('APP_URL') ?>App/View/assets/js/main.js"></script>
    <script src="<?= Config::get('APP_URL') ?>App/View/assets/js/adm/autocomplete-pessoas.js"></script>
    <script src="<?= Config::get('APP_URL') ?>App/View/assets/js/adm/desvincula-docente.js"></script>
</body>
</html>