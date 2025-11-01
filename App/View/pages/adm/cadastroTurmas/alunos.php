<?php

require_once __DIR__ . "/../../../../Config/App.php";
require_once __DIR__ . "/../../../../Helpers/Redirect.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../../Service/AuthService.php";
require_once __DIR__ . "/../../../../Model/AlunoModel.php";
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";
require_once __DIR__ . "/../../../componentes/BreadCrumbs.php";

$turmaId = Request::getId("turma_id");
if (!$turmaId) {
    Redirect::toAdm('listaTurmas.php');
}

$paginaAtiva = 'turmas';
headerComponent("Voucher Desenvolvedor - Alunos");
$currentTab = 'Alunos';
$alunos = [];
$isEditMode = true;

try {
    $alunoModel = new AlunoModel();
    $alunos = $alunoModel->buscarAlunosPorTurma($turmaId);
} catch (Exception $e) {
    error_log("Erro ao buscar alunos: " . $e->getMessage());
    $error_message = "Erro ao carregar alunos.";
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
        <?php BreadCrumbs::gerarBreadCrumbs(); ?>
        <?php tabsTurmaComponent($currentTab, ["turma_id" => $turmaId]); ?>

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

        <?php
        $isAdmin = true;
        require_once __DIR__ . "/../../../componentes/nav.php";
        ?>

        

        <div class="topo-lista-alunos">
            <?php buttonComponent('primary', 'VINCULAR ALUNO', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro()\""); ?>
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
                        <?php if (!empty($alunos)): ?>
                            <?php foreach ($alunos as $aluno): ?>
                                <tr>
                                    <td><?= htmlspecialchars($aluno['nome']) ?></td>
                                    <td><?= htmlspecialchars($aluno['polo']) ?></td>
                                    <td class="acoes">
                                        <?php if ($is_admin): ?>
                                            <span class="material-symbols-outlined acao-delete" title="Desvincular aluno" onclick="confirmarDesvinculacao(<?= $aluno['pessoa_id'] ?>, <?= $turmaId ?>, '<?= htmlspecialchars($aluno['nome']) ?>')">delete</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="empty-table-cell">Nenhum aluno vinculado a esta turma.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <section class="section_modal">
                    <form class="modal-confirmacao" method="POST" id="modal-desvincular-aluno" action="/galeria-voucher/App/Controller/DesvincularAlunoController.php?action=desvincular">
                        <div class="modal-header modal-desvincular">
                            <h3>Confirmar Desvinculação</h3>
                            <span class="material-symbols-outlined modal-header-action btn-close-desvincular" name="btn-close" onclick="fecharModal()">close</span>
                        </div>
                        <div class="modal-body">
                            <p>Tem certeza que deseja desvincular o aluno "<span id="aluno-confirmacao"></span>" desta turma?</p>
                            <p class="warning-text">Esta ação requer confirmação da sua senha.</p>
                            <div class="form-group">
                                <label for="senha-confirmacao">Digite sua senha:</label>
                                <input type="password" id="senha-confirmacao" name="senha" required>
                                <input type="hidden" name="pessoa_id">
                                <input type="hidden" name="turma_id">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="secondary-button" onclick="fecharModal()">Cancelar</button>
                            <button type="submit" class="primary-button">Desvincular</button>
                        </div>
                    </form>

                <div class="modal modal-cadastro" id="modal-cadastro-aluno">
                    <div class="modal-header">
                        <span class="material-symbols-outlined modal-header-action btn-close" name="btn-close">close</span>
                    </div>
                    
                    <form class="form-cadastro-pessoa" method="POST" action="">
                        <div class="modal-body">
                            <div>
                                <label for="pesquisar-pessoa">
                                    Pesquisar Alunos
                                </label>
                                <?php inputComponent('text', 'pesquisar-pessoa', 'Digite um nome'); ?>
                                <div id="sugestoes">
                                    
                                    </div>
                            </div>

                            <div id="pessoas-selecionadas"></div>

                            <input type="hidden" name="turma_id" value="<?= $turmaId ?>">

                        </div>

                        <div class="modal-action">
                            <?php buttonComponent("primary", "Vincular", true)?>
                        </div>
                    </form>
                </div>
            </section>
    </div>
    </main>
    </div>
    
    <script src="<?= Config::get('APP_URL') ?>App/View/assets/js/adm/lista-alunos.js"></script>
    <script src="<?= Config::get('APP_URL') ?>App/View/assets/js/main.js"></script>
    <script src="<?= Config::get('APP_URL') ?>App/View/assets/js/adm/autocomplete-pessoas.js"></script>
    <script src="<?= Config::get('APP_URL') ?>App/View/assets/js/adm/desvincula-aluno.js"></script>
</body>
</html>