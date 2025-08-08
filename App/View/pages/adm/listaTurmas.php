<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../Model/TurmaModel.php";

headerComponent("Voucher Desenvolvedor - Turmas");

try {
    $turmaModel = new TurmaModel();
    $turmas = $turmaModel->buscarTodasTurmasComPolo();
} catch (Exception $e) {
    $turmas = [];
    error_log("Erro ao buscar turmas: " . $e->getMessage());
}
?>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="body-lista-alunos">

    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../componentes/nav.php";
    ?>

    <main class="main-lista-alunos">
        <div class="container-lista-alunos">
            <div class="topo-lista-alunos">
                <a href="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php' ?>" class="primary-button" style="text-decoration: none;">NOVA</a>
                <div class="input-pesquisa-container">
                    <input type="text" id="pesquisa" placeholder="Pesquisar por nome ou polo">
                    <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/lupa.png" alt="Ícone de lupa" class="icone-lupa-img">
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
                            <?php if (!empty($turmas)) : ?>
                                <?php foreach ($turmas as $turma) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($turma['NOME_TURMA']) ?></td>
                                        <td><?= htmlspecialchars($turma['NOME_POLO']) ?></td>
                                        <td class="acoes">
                                            <div class="acoes-container">
                                                <a href="cadastroTurmas/cadastroTurmas.php?id=<?= $turma['turma_id'] ?>" title="Editar">
                                                    <span class="material-symbols-outlined acao-edit">edit</span>
                                                </a>
                                                <form method="POST" action="<?= VARIAVEIS['APP_URL'] ?>App/Controls/TurmaController.php?action=excluir" onsubmit="return confirm('Tem certeza que deseja excluir esta turma?');">
                                                    <input type="hidden" name="turma_id" value="<?= $turma['turma_id'] ?>">
                                                    <button type="submit" class="btn-acao-delete" title="Excluir">
                                                        <span class="material-symbols-outlined acao-delete">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" style="text-align: center;">Nenhuma turma encontrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
    
    <?php if (isset($_SESSION['sucesso_exclusao'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            alert("<?= htmlspecialchars($_SESSION['sucesso_exclusao']) ?>");
        });
    </script>
    <?php unset($_SESSION['sucesso_exclusao']); // Limpa a sessão para não mostrar o alerta novamente ?>
    <?php endif; ?>
    
    <script src="../../assets/js/adm/lista-alunos.js"></script>
</body>
</html>