<?php
// Inclui arquivos essenciais de configuração, componentes e o Model.
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../Model/TurmaModel.php";

// Define o título da página.
headerComponent("Voucher Desenvolvedor - Turmas");

// --- LÓGICA DE PAGINAÇÃO E BUSCA ---
$turmaModel = new TurmaModel();
$termoPesquisa = $_GET['pesquisa'] ?? '';
$paginaAtual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$turmasPorPagina = 10;
$offset = ($paginaAtual - 1) * $turmasPorPagina;

try {
    $totalTurmas = $turmaModel->contarTotalTurmas($termoPesquisa);
    $totalPaginas = ceil($totalTurmas / $turmasPorPagina);
    $turmas = $turmaModel->buscarTurmasPaginado($turmasPorPagina, $offset, $termoPesquisa);
} catch (Exception $e) {
    $turmas = [];
    $totalPaginas = 0;
    error_log("Erro ao buscar turmas: " . $e->getMessage());
}

$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';
?>

<head>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />                                                                                                                     

</head>

<body class="body-lista-alunos">

    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; // Inclui a barra lateral ?>
    <?php
    $isAdmin = true; // Informa ao componente de navegação que esta é uma página de admin.
    require_once __DIR__ . "/../../componentes/nav.php"; // Inclui a barra de navegação superior.
    ?>

    <main class="main-lista-alunos">
        <div class="container-lista-alunos">
            <div class="topo-lista-alunos">
                <?php
                buttonComponent(
                    'primary','NOVA TURMA',false,VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php');
                ?>
                
                <form method="GET" action="">
                    <div class="input-pesquisa-container">
                        <input 
                            type="text" 
                            id="pesquisa" 
                            name="pesquisa"  
                            placeholder="Pesquisar por nome ou polo" 
                            value="<?= htmlspecialchars($termoPesquisa) ?>">
                        
                        <button type="submit" class="search-button">
                            <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/lupa.png" alt="Ícone de lupa"
                                class="icone-lupa-img">
                        </button>
                    </div>
                </form>
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
                            <?php if (!empty($turmas)):  // Verifica se existem turmas para exibir. ?>
                                <?php foreach ($turmas as $turma): // Loop para criar uma linha <tr> para cada turma. ?>
                                    <tr>
                                        <td><?= htmlspecialchars($turma['NOME_TURMA']) ?></td>
                                        <td><?= htmlspecialchars($turma['NOME_POLO']) ?></td>
                                        <td class="acoes">
                                            <div class="acoes-container">
                                                <a href="cadastroTurmas/cadastroTurmas.php?id=<?= $turma['turma_id'] ?>"
                                                    title="Editar">
                                                    <span class="material-symbols-outlined" id="edite">edit</span>
                                                </a>

                                                <form method="POST"
                                                    action="<?= VARIAVEIS['APP_URL'] ?>App/Controls/TurmaController.php?action=excluir"
                                                    onsubmit="return confirm('ATENÇÃO!!! Excluir esta turma também removerá todos os seus projetos, alunos e professores vinculados. Esta ação é irreversível. Deseja continuar?');">
                                                    <input type="hidden" name="turma_id" value="<?= $turma['turma_id'] ?>">
                                                    <button type="submit" class="no-style" title="Excluir">
                                                        <span class="material-symbols-outlined acao-delete">delete</span>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else:  // Se o array $turmas estiver vazio... ?>
                                <tr>
                                    <td colspan="3" style="text-align: center;">Nenhuma turma encontrada.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="paginacao-container">
                <?php if ($totalPaginas > 1): ?>
                    <div class="paginacao">
                        <a href="?pagina=1<?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" class="paginacao-item">&laquo;</a>
                        
                        <?php if ($paginaAtual > 1): ?>
                            <a href="?pagina=<?= $paginaAtual - 1 ?><?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" class="paginacao-item">&lsaquo;</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                            <a href="?pagina=<?= $i ?><?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" 
                               class="paginacao-item <?= ($i == $paginaAtual) ? 'paginacao-ativa' : '' ?>">
                                <?= $i ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($paginaAtual < $totalPaginas): ?>
                            <a href="?pagina=<?= $paginaAtual + 1 ?><?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" class="paginacao-item">&rsaquo;</a>
                        <?php endif; ?>

                        <a href="?pagina=<?= $totalPaginas ?><?= !empty($termoPesquisa) ? '&pesquisa=' . urlencode($termoPesquisa) : '' ?>" class="paginacao-item">&raquo;</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <?php // Script para exibir a mensagem de sucesso após a exclusão de uma turma. ?>
    <?php if (isset($_SESSION['sucesso_exclusao'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                alert("<?= htmlspecialchars($_SESSION['sucesso_exclusao']) ?>");
            });
        </script>
        <?php unset($_SESSION['sucesso_exclusao']); // Limpa a sessão para não mostrar o alerta novamente. ?>
    <?php endif; ?>

    <script src="../../assets/js/adm/lista-alunos.js"></script>
</body>

</html>