<?php
// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/adm/auth.php"; 
require_once __DIR__ . "/../../../../Model/DocenteModel.php"; 

headerComponent("Voucher Desenvolvedor - Docentes");
$currentTab = 'docentes';

// 2. LÓGICA DE BUSCA DE DADOS
try {
    $docenteModel = new DocenteModel();
    $docentes = $docenteModel->buscarTodosDocentesComPolo();
    
} catch (Exception $e) {
    // Em caso de erro, define $docentes como um array vazio e loga o erro
    $docentes = [];
    error_log("Erro ao buscar docentes: " . $e->getMessage());
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
            <div class="tabs-adm-turmas">
                <a class="tab-adm-turmas <?= ($currentTab == 'dados-gerais') ? 'active' : '' ?>" href="cadastroTurmas.php">DADOS GERAIS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'projetos') ? 'active' : '' ?>" href="CadastroProjetos.php">PROJETOS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'docentes') ? 'active' : '' ?>" href="docentes.php">DOCENTES</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'alunos') ? 'active' : '' ?>" href="alunos.php">ALUNOS</a>
            </div>

            <div class="topo-lista-alunos">
                <?php buttonComponent('primary', 'VINCULAR', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('professor')\""); ?>

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
                            <?php if (!empty($docentes)) : ?>
                                <?php foreach ($docentes as $docente) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($docente['nome']) ?></td>
                                        <td><?= htmlspecialchars($docente['polo']) ?></td>
                                        <td class="acoes">
                                            <?php if ($is_admin) : ?>
                                                <span class="material-symbols-outlined acao-delete" style="cursor: pointer;" title="Excluir">delete</span>
                                            <?php endif; ?>
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

    <script src="../../../assets/js/adm/lista-alunos.js"></script>
    <script src="../../../assets/js/main.js"></script>
    <script src="../../../assets/js/adm/autocomplete-pessoas.js"></script>

</body>

</html>