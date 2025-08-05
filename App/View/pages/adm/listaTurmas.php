<?php
// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/adm/auth.php"; // Garante que apenas usuários logados acessem
require_once __DIR__ . "/../../../Model/TurmaModel.php";

headerComponent("Voucher Desenvolvedor - Turmas");

// 2. LÓGICA DE BUSCA DE DADOS
try {
    $turmaModel = new TurmaModel();
    $turmas = $turmaModel->buscarTodasTurmasComPolo();
} catch (Exception $e) {
    // Em caso de erro, define $turmas como um array vazio e loga o erro
    $turmas = [];
    error_log("Erro ao buscar turmas: " . $e->getMessage());
}

// Verifica se o usuário logado é um administrador para exibir o botão de excluir
$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';

?>

<head>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="body-lista-alunos">

    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true; // Define que esta é uma página de admin para o nav.php
    require_once __DIR__ . "/../../componentes/nav.php";
    ?>

    <main class="main-lista-alunos">

        
        
        <div class="container-lista-alunos">
            <div class="topo-lista-alunos">
                <?php buttonComponent('primary', 'NOVA', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/cadastroTurmas.php'); ?>

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
                                            <span class="material-symbols-outlined acao-edit" style="cursor: pointer; margin-right: 10px;" title="Editar">edit</span>
                                            
                                            <?php if ($is_admin) : ?>
                                                <span class="material-symbols-outlined acao-delete" style="cursor: pointer;" title="Excluir">delete</span>
                                            <?php endif; ?>
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
    
    <script src="../../assets/js/adm/lista-alunos.js"></script>

</body>

</html>