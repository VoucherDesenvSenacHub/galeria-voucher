<?php
<<<<<<< HEAD
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/adm/auth.php";
=======
// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/adm/auth.php"; // Garante que apenas usuários logados acessem
>>>>>>> e6bc4b973c6f2f69a4ff8870f3b76264d0bcd04b
require_once __DIR__ . "/../../../Model/TurmaModel.php";

headerComponent("Voucher Desenvolvedor - Turmas");

<<<<<<< HEAD
=======
// 2. LÓGICA DE BUSCA DE DADOS
>>>>>>> e6bc4b973c6f2f69a4ff8870f3b76264d0bcd04b
try {
    $turmaModel = new TurmaModel();
    $turmas = $turmaModel->buscarTodasTurmasComPolo();
} catch (Exception $e) {
<<<<<<< HEAD
    $turmas = [];
    error_log("Erro ao buscar turmas: " . $e->getMessage());
}
=======
    // Em caso de erro, define $turmas como um array vazio e loga o erro
    $turmas = [];
    error_log("Erro ao buscar turmas: " . $e->getMessage());
}

// Verifica se o usuário logado é um administrador para exibir o botão de excluir
$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';

>>>>>>> e6bc4b973c6f2f69a4ff8870f3b76264d0bcd04b
?>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="body-lista-alunos">

    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
    <?php
<<<<<<< HEAD
    $isAdmin = true;
=======
    $isAdmin = true; // Define que esta é uma página de admin para o nav.php
>>>>>>> e6bc4b973c6f2f69a4ff8870f3b76264d0bcd04b
    require_once __DIR__ . "/../../componentes/nav.php";
    ?>

    <main class="main-lista-alunos">
        <div class="container-lista-alunos">
            <div class="topo-lista-alunos">
<<<<<<< HEAD
                <a href="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php' ?>" class="primary-button" style="text-decoration: none;">NOVA TURMA</a>
=======
                <?php buttonComponent('primary', 'NOVA', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php'); ?>

>>>>>>> e6bc4b973c6f2f69a4ff8870f3b76264d0bcd04b
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
<<<<<<< HEAD
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
=======
                                        
                                        <td class="acoes">
                                            <span class="material-symbols-outlined acao-edit" style="cursor: pointer; margin-right: 10px;" title="Editar">edit</span>
                                            
                                            <?php if ($is_admin) : ?>
                                                <span class="material-symbols-outlined acao-delete" style="cursor: pointer;" title="Excluir">delete</span>
                                            <?php endif; ?>
>>>>>>> e6bc4b973c6f2f69a4ff8870f3b76264d0bcd04b
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
    
<<<<<<< HEAD
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
=======
    <script src="../../assets/js/adm/lista-alunos.js"></script>

</body>

>>>>>>> e6bc4b973c6f2f69a4ff8870f3b76264d0bcd04b
</html>