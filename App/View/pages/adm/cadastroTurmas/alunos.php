<?php
// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/AlunoModel.php"; // Inclui o AlunoModel

headerComponent("Voucher Desenvolvedor - Alunos");
$currentTab = 'alunos';

// 2. LÓGICA DE BUSCA DE DADOS
try {
    $alunoModel = new AlunoModel();
    $alunos = $alunoModel->buscarTodosAlunosComPolo();
} catch (Exception $e) {
    // Em caso de erro, define $alunos como um array vazio e loga o erro
    $alunos = [];
    error_log("Erro ao buscar alunos: " . $e->getMessage());
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
        $isAdmin = true; // Para páginas de admin
        require_once __DIR__ . "/../../../componentes/nav.php";
        ?>

        <main class="main-turmas-turmas">

            <section class="section_modal">

            </section>
            <div class="tabs-adm-turmas">
                <a class="tab-adm-turmas <?= ($currentTab == 'dados-gerais') ? 'active' : '' ?>" href="cadastroTurmas.php">DADOS GERAIS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'projetos') ? 'active' : '' ?>" href="CadastroProjetos.php">PROJETOS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'docentes') ? 'active' : '' ?>" href="docentes.php">DOCENTES</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'alunos') ? 'active' : '' ?>" href="alunos.php">ALUNOS</a>
            </div>

            <div class="topo-lista-alunos">
                <?php buttonComponent('primary', 'VINCULAR', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('aluno')\""); ?>

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
                            <?php if (!empty($alunos)) : ?>
                                <?php foreach ($alunos as $aluno) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($aluno['nome']) ?></td>
                                        <td><?= htmlspecialchars($aluno['polo']) ?></td>
                                        <td class="acoes">
                                            <?php if ($is_admin) : ?>
                                                <span class="material-symbols-outlined acao-delete" style="cursor: pointer;" title="Excluir">delete</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="3" style="text-align: center;">Nenhum aluno encontrado.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>

    <script src="../../../assets/js/adm/lista-alunos.js"></script>
    <script src="../../../assets/js/main.js"></script>
    <script src="../../../assets/js/adm/autocomplete-pessoas.js"></script>
</body>

</html>