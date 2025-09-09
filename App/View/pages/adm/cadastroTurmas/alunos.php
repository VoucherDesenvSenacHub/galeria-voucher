<?php

$paginaAtiva = 'turmas';

// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../Service/AuthService.php";
require_once __DIR__ . "/../../../../Model/AlunoModel.php";
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";
require_once __DIR__ . "/../../../componentes/BreadCrumbs.php";
require_once __DIR__ . "/../../../../Model/DocenteModel.php";

headerComponent("Voucher Desenvolvedor - Alunos");
$currentTab = 'Alunos';

// 2. LÓGICA DE BUSCA DE DADOS
$alunos = [];
$isEditMode = false;
$turmaId = null;

// 3. LÓGICA DE BUSCA DE DADOS
try {
    $alunoModel = new AlunoModel();

    // Verifica se o ID da turma foi passado (modo edição)
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $turmaId = (int) $_GET['id'];

        if ($turmaId > 0) {
            $isEditMode = true;
            $alunos = $alunoModel->buscarAlunosPorTurma($turmaId);
        }
    }
    // Se não houver ID, está no modo cadastro (não é erro)

} catch (Exception $e) {
    // Em caso de erro, define $alunos como um array vazio e loga o erro
    $alunos = [];
    error_log("Erro ao buscar alunos: " . $e->getMessage());

    // Exibe mensagem de erro para o usuário apenas se estiver no modo edição
    if ($isEditMode) {
        $error_message = "Erro ao carregar alunos: " . $e->getMessage();
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
                buttonComponent('primary', 'VINCULAR ALUNO', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('professor')\"");
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
                            <?php if (!empty($alunos)): ?>
                                <?php foreach ($alunos as $aluno): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($aluno['nome']) ?></td>
                                        <td><?= htmlspecialchars($aluno['polo']) ?></td>
                                        <td class="acoes">
                                            <?php if ($is_admin): ?>
                                                <span class="material-symbols-outlined acao-delete" title="Desvincular aluno"
                                                    onclick="confirmarDesvinculacao(<?= $aluno['pessoa_id'] ?>, <?= $turmaId ?>, '<?= htmlspecialchars($aluno['nome']) ?>')">delete</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="empty-table-cell">
                                        <?php if ($isEditMode): ?>
                                            <?= isset($error_message) ? 'Erro ao carregar dados' : 'Nenhum aluno vinculado a esta turma.' ?>
                                        <?php else: ?>
                                            <div class="empty-state-container">
                                                <p class="empty-state-title">Nenhum aluno cadastrado ainda.</p>
                                                <p class="empty-state-description">Clique em "VINCULAR ALUNO" para adicionar
                                                    alunos à turma.</p>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
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
    <script src="../../../assets/js/adm/desvincula-aluno.js"></script>

</body>

</html>