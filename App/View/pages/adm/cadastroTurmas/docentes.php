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

            <?php if (isset($_SESSION['erro'])): ?>
                <div class="error-message">
                    <?= htmlspecialchars($_SESSION['erro']) ?>
                </div>
                <?php unset($_SESSION['erro']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['sucesso'])): ?>
                <div class="success-message">
                    <?= htmlspecialchars($_SESSION['sucesso']) ?>
                </div>
                <?php unset($_SESSION['sucesso']); ?>
            <?php endif; ?>

            <div class="topo-lista-alunos">
                <?php
                buttonComponent('primary', 'VINCULAR DOCENTE', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('professor', " . $turmaId . ")\"");
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
                                    <tr>
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
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="empty-table-cell">
                                        <?php if ($isEditMode): ?>
                                            <?= isset($error_message) ? 'Erro ao carregar dados' : 'Nenhum docente vinculado a esta turma.' ?>
                                        <?php else: ?>
                                            <div class="empty-state-container">
                                                <p class="empty-state-title">Nenhum docente cadastrado ainda.</p>
                                                <p class="empty-state-description">Clique em "VINCULAR DOCENTE" para adicionar
                                                    docentes à turma.</p>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <section class="section_modal">
                <div class="modal-confirmacao" id="modal-desvincular-docente">
                    <form class="modal-content" method="POST" action="/galeria-voucher/App/Controller/DocenteController.php?action=desvincular">
                        <div class="modal-header">
                            <h3>Confirmar Desvinculação</h3>
                            <span class="close-modal" onclick="fecharModal()">&times;</span>
                        </div>
                        <div class="modal-body">
                            <p>Tem certeza que deseja desvincular o docente "<span id="docente-confirmacao"></span>" desta turma?</p>
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
                            <button type="submit" class="primary-button" >Desvincular</button>
                        </div>
                    </form>
                </div>
            </section>
        </main>
    </div>

    <script src="../../../assets/js/adm/lista-alunos.js"></script>
    <script src="../../../assets/js/main.js"></script>
    <script src="../../../assets/js/adm/autocomplete-pessoas.js"></script>
    <script src="../../../assets/js/adm/desvincula-docente.js"></script>

</body>

</html>