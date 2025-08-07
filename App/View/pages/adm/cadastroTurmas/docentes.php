<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/DocenteModel.php"; // Incluímos o novo Model

headerComponent("Voucher Desenvolvedor - Docentes");
$currentTab = 'docentes';

// ATENÇÃO: Substitua '1' pelo ID real da turma que está sendo editada.
// Você pode obter esse ID da URL (via $_GET['id']) ou de uma variável de sessão.
$turma_id = 1; 

// Pega o termo de pesquisa da URL, se existir
$pesquisa = $_GET['pesquisa'] ?? null;

// Busca os docentes no banco de dados
try {
    $docenteModel = new DocenteModel();
    $docentes = $docenteModel->buscarDocentesPorTurma($turma_id, $pesquisa);
} catch (Exception $e) {
    // Em caso de erro, define o array como vazio para não quebrar a página
    $docentes = [];
    error_log("Erro ao buscar docentes: " . $e->getMessage());
}
?>

<body class="body-adm">
    <div class="container-adm">
        <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>

        <?php
        $isAdmin = true; // Para páginas de admin
        require_once __DIR__ . "/../../../componentes/nav.php";
        ?>

        <main class="main-turmas-turmas">
            <div class="tabs-adm-turmas">
                <a class="tab-adm-turmas <?= ($currentTab == 'dados-gerais') ? 'active' : '' ?>" href="cadastroTurmas.php">DADOS GERAIS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'projetos') ? 'active' : '' ?>" href="CadastroProjetos.php">PROJETOS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'docentes') ? 'active' : '' ?>" href="docentes.php">DOCENTES</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'alunos') ? 'active' : '' ?>" href="alunos.php">ALUNOS</a>
            </div>

            <div class="topo-lista-alunos">
                <?php buttonComponent('primary', 'VINCULAR', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('professor')\""); ?>

                <form method="GET" action="" class="input-pesquisa-container">
                    <input type="text" id="pesquisa" name="pesquisa" placeholder="Pesquisar por nome" value="<?= htmlspecialchars($pesquisa ?? '') ?>">
                    <button type="submit" style="background: none; border: none; cursor: pointer;">
                        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>adm/lupa.png" alt="Ícone de lupa" class="icone-lupa-img">
                    </button>
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
                            <?php if (!empty($docentes)) : ?>
                                <?php foreach ($docentes as $docente) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($docente['nome']) ?></td>
                                        <td><?= htmlspecialchars($docente['polo']) ?></td>
                                        <td class="acoes">
                                            <span class="material-symbols-outlined acao-delete" style="cursor: pointer;" title="Excluir">delete</span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" style="text-align: center;">Nenhum docente encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <section class="section_modal"></section>
        </main>
    </div>

    <script src="../../../assets/js/main.js"></script>
    <script src="../../../assets/js/adm/autocomplete-pessoas.js"></script>
</body>

</html>