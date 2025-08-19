<?php
// 1. INCLUDES E AUTENTICAÇÃO
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/adm/auth.php"; 
require_once __DIR__ . "/../../../../Model/DocenteModel.php"; 

headerComponent("Voucher Desenvolvedor - Docentes");
$currentTab = 'docentes';

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
            <div class="tabs-adm-turmas">
                <a class="tab-adm-turmas <?= ($currentTab == 'dados-gerais') ? 'active' : '' ?>" href="cadastroTurmas.php<?= $turmaId ? '?id=' . $turmaId : '' ?>">DADOS GERAIS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'projetos') ? 'active' : '' ?>" href="CadastroProjetos.php<?= $turmaId ? '?id=' . $turmaId : '' ?>">PROJETOS</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'docentes') ? 'active' : '' ?>" href="docentes.php<?= $turmaId ? '?id=' . $turmaId : '' ?>">DOCENTES</a>
                <a class="tab-adm-turmas <?= ($currentTab == 'alunos') ? 'active' : '' ?>" href="alunos.php<?= $turmaId ? '?id=' . $turmaId : '' ?>">ALUNOS</a>
            </div>

            <?php if (isset($error_message)) : ?>
                <div class="error-message" style="background: #ffebee; color: #c62828; padding: 1rem; margin: 1rem 0; border-radius: 8px; border: 1px solid #ffcdd2;">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>

            <!-- Título dinâmico baseado no modo -->
            <div style="text-align: center; margin: 2rem 0;">
                <h1 style="color: #2c3e50; font-size: 2rem; font-weight: 700;">
                    <?= $isEditMode ? 'Editar Docentes da Turma' : 'Cadastrar Nova Turma - Docentes' ?>
                </h1>
                <?php if ($isEditMode) : ?>
                    <p style="color: #6c757d; font-size: 1.1rem; margin-top: 0.5rem;">
                        ID da Turma: <?= $turmaId ?>
                    </p>
                <?php endif; ?>
            </div>

            <div class="topo-lista-alunos">
                <?php 
                $buttonText = $isEditMode ? 'VINCULAR DOCENTE' : 'VINCULAR DOCENTE';
                buttonComponent('primary', $buttonText, false, null, null, "id='btn-cadastrar-pessoa' onclick=\"abrirModalCadastro('professor')\""); 
                ?>

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
                                    <td colspan="3" style="text-align: center; padding: 2rem; color: #6c757d;">
                                        <?php if ($isEditMode) : ?>
                                            <?= isset($error_message) ? 'Erro ao carregar dados' : 'Nenhum docente vinculado a esta turma.' ?>
                                        <?php else : ?>
                                            <div style="text-align: center;">
                                                <p style="margin-bottom: 1rem; font-size: 1.1rem;">Nenhum docente cadastrado ainda.</p>
                                                <p style="color: #6c757d; font-size: 0.9rem;">Clique em "VINCULAR DOCENTE" para adicionar docentes à turma.</p>
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

</body>

</html>