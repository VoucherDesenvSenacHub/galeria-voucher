<?php

require_once __DIR__ . "/../../../Config/Config.php";
require_once __DIR__ . "/../../../Helpers/Redirect.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../../Service/AuthService.php";
require_once __DIR__ . "/../../componentes/adm/tabsTurma.php";
require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../componentes/BreadCrumbs.php";

headerComponent("Voucher Desenvolvedor - Projetos");

$turmaId = Request::getId("turma_id");

if (!$turmaId) {
    Redirect::toAdm('turmas.php');
}

$paginaAtiva = 'turmas';
$currentTab = 'Projetos';
$projetos = [];

try {
    $turmaModel = new TurmaModel();
    // Esta função foi corrigida anteriormente para buscar os projetos
    $projetos = $turmaModel->buscarProjetosPorTurma($turmaId);
} catch (Exception $e) {
    $projetos = [];
    error_log("Erro ao buscar projetos: " . $e->getMessage());
    $error_message = "Erro ao carregar projetos.";
}

$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';
?>
<head>
    <link rel="stylesheet" href="<?= Config::getDirCss() ?>adm/cadastro-projetos.css">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link rel="stylesheet" href="<?= Config::getDirCss() ?>adm/lista-alunos.css">
</head>


<body class="layout body-adm">
    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../componentes/nav.php";
    ?>

    <main class="layout-main main-turmas-turmas">
        <?php BreadCrumbs::gerarBreadCrumbs(); ?>
        <?php tabsTurmaComponent($currentTab, ["turma_id" => $turmaId]); ?>

        <div class="topo-lista-alunos">
            <?php
            buttonComponent(
                'primary',
                'ADICIONAR',
                false,
                Config::getDirAdm() . 'CadastroProjetos.php' . ($turmaId ? "?turma_id=$turmaId" : '')
            );
            ?>

            <div class="input-pesquisa-container">
                <input type="text" id="pesquisa" placeholder="Pesquisar por nome...">
                <img src="<?= Config::getDirImg() ?>adm/lupa.png" alt="Ícone de lupa" class="icone-lupa-img">
            </div>
        </div>

        <?php if (isset($error_message)): ?>
            <div class="error-message"><?= htmlspecialchars($error_message) ?></div>
        <?php endif; ?>

        <div class="tabela-principal-lista-alunos">
            <div class="tabela-container-lista-alunos">
                <table id="tabela-alunos">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>NOME</th>
                            <th>DESCRIÇÃO</th>
                            <th>AÇÕES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($projetos)): ?>
                            <?php foreach ($projetos as $projeto): ?>
                                <tr>
                                    <td><?= htmlspecialchars($projeto['projeto_id']) ?></td>
                                    <td><?= htmlspecialchars($projeto['NOME_PROJETO']) ?></td>
                                    <td><?= htmlspecialchars(mb_strimwidth($projeto['DESCRICAO_PROJETO'], 0, 100, "...")) ?></td>
                                    <td class="acoes">
                                        <div class="acoes-container">
                                            <span class="material-symbols-outlined action-icon" style="cursor: pointer;" title="Editar">edit</span>
                                            <span class="material-symbols-outlined" style="cursor: pointer;" title="Excluir">delete</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">Nenhum projeto encontrado para esta turma.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
    </main>
</body>
</html>
