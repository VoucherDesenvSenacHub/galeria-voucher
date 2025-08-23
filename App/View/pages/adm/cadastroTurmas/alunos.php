<?php
// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/AlunoModel.php"; // Inclui o AlunoModel
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";

headerComponent("Voucher Desenvolvedor - Alunos");
$currentTab = 'Alunos';

// 2. LÓGICA DE BUSCA DE DADOS
$alunos = [];
$isEditMode = false;
$turmaId = null;

try {
    $alunoModel = new AlunoModel();

    // Verifica se o ID da turma foi passado (modo edição)
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $turmaId = (int) $_GET['id'];

        if ($turmaId > 0) {
            $isEditMode = true;
            $alunos = $alunoModel->buscarTodosAlunosComPolo();
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
        $isAdmin = true; // Para páginas de admin
        require_once __DIR__ . "/../../../componentes/nav.php";
        ?>

        <main class="main-turmas-turmas">
            <section class="section_modal">

            </section>
            <?php
            // Usa o componente de abas das turmas
            $turmaId = isset($_GET['id']) ? (int) $_GET['id'] : null;
            tabsTurmaComponent($currentTab, $turmaId);
            ?>

            <div class="page-title-container">
                <h1 class="page-title">
                    <?= $isEditMode ? 'Editar > ' . $currentTab : 'Cadastrar > ' . $currentTab ?>
                </h1>
            </div>


            <div class="topo-lista-alunos">
                <?php buttonComponent('primary', 'VINCULAR ALUNO', false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('aluno')\""); ?>

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
                                                <span class="material-symbols-outlined acao-delete" title="Excluir">delete</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="empty-table-cell">Nenhum aluno encontrado.</td>
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