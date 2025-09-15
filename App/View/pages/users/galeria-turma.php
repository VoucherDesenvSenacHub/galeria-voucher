<?php
// require_once __DIR__ . "/../../componentes/head.php";

// Carrega variáveis de ambiente antes de qualquer uso de VARIAVEIS
require_once __DIR__ . "/../../../Config/env.php";

// Carrega dependências necessárias para buscar dados
require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../Model/ProjetoModel.php";
require_once __DIR__ . "/../../../Model/AlunoModel.php";
require_once __DIR__ . "/../../../Model/DocenteModel.php";
require_once __DIR__ . "/../../../Helpers/ProjetoHelper.php";
require_once __DIR__ . "/../../../Helpers/HtmlHelper.php";
require_once __DIR__ . "/../../../Controls/GaleriaTurmaController.php";

// Obtém ID da turma via URL e carrega dados
$controller = new GaleriaTurmaController();
$turmaId = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;
if ($turmaId <= 0) {
    header("Location: ./turma.php");
    exit;
}
$dados = $controller->carregarDadosTurma($turmaId);

// Extrai variáveis usadas pela view
$imagemTurmaUrl   = $dados['imagemTurmaUrl'] ?? VARIAVEIS["DIR_IMG"] . 'utilitarios/foto.png';
$nomeTurma        = $dados['nomeTurma'] ?? '';
$descricaoTurma   = $dados['descricaoTurma'] ?? '';
$alunos           = $dados['alunos'] ?? [];
$orientadores     = $dados['orientadores'] ?? [];
$tabsProjetos     = $dados['tabsProjetos'] ?? [];
$projetosFormatados = $dados['projetosFormatados'] ?? [];
$polo             = $dados['polo'] ?? '';
$cidade           = $dados['cidade'] ?? '';

$pessoasTurma = [];

$pessoasTurma = array_merge($pessoasTurma, $alunos);
$pessoasTurma = array_merge($pessoasTurma, $orientadores);

// Log leve para depuração
if (function_exists('error_log')) {
    error_log("galeria-turma id={$turmaId} alunos=" . (is_array($alunos) ? count($alunos) : 0) . " orientadores=" . (is_array($orientadores) ? count($orientadores) : 0));
}

// Define o título da página 
require_once __DIR__ . "/../../componentes/head.php";
headerComponent('Galeria da Turma');
?>

<body class="galeria-turma-body">

    <!-- ------------------- CABEÇALHO COM MENU ------------------- -->
    <header class="galeria-turma-header">
        <?php
        $isAdmin = false;
        require_once __DIR__ . "/../../componentes/nav.php";
        require_once __DIR__ . "/../../componentes/users/mira.php";
        ?>
    </header>

    <!-- ------------------- DETALHES DA TURMA ------------------- -->
    <section class="galeria-turma-section galeria-turma-projeto">
        <h1 class="galeria-turma-h1 projetos-turma">Projetos da turma</h1>

        <section class="galeria-turma-senac">
            <h3 class="galeria-turma-h3"><?= $polo ?></h3>
            <h3 class="galeria-turma-h3"><?= $cidade ?></h3>
        </section>

        <section class="galeria-turma-tab-inner">
            <img class="galeria-turma-imagem-direita" src="<?php echo VARIAVEIS['APP_URL'] . $imagemTurmaUrl ?>" alt="Imagem da Turma">
            <div class="galeria-turma-margin-top-left-projeto1-dia-i">
                <h2><?= $nomeTurma ?></h2>
                <p><?= $descricaoTurma ?></p>
            </div>
        </section>

        <!-- ------------------- SEÇÃO DE PROJETOS ------------------- -->
        <section class="galeria-turma-section galeria-turma-galeria projetos-turma galeria-turma-no-side-padding">
            <h1 class="galeria-turma-h1">Galeria de Projetos</h1>

            <!-- Navegação principal dos projetos -->
            <div class="galeria-turma-main-tabs-nav">
                <?php foreach ($tabsProjetos as $tab): ?>
                    <a class="galeria-turma-main-tab-btn <?= $tab['classe_css'] ?>" data-projeto="<?= $tab['projeto_id'] ?>">
                        <?= $tab['nome'] ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Conteúdo dos projetos -->
            <div class="galeria-turma-main-tabs-content">
                <?php foreach ($projetosFormatados as $projeto): ?>
                    <div class="galeria-turma-main-tab-content <?= $projeto['ativo'] ? 'active' : '' ?>" id="main-tab-<?= $projeto['projeto_id'] ?>">

                        <div class="galeria-turma-projeto-intro">
                            <p><?= $projeto['descricao'] ?></p>
                        </div>

                        <div class="galeria-turma-sub-tabs-nav">
                            <?php
                            foreach ($projeto['dias'] as $i => $dia) {
                                renderSubTabBtn($dia, $i, $projeto['projeto_id'], $dia['linkProjeto']);
                            }
                            renderRepoBtn($projeto, $projeto['dias']);
                            ?>
                        </div>

                        <div class="galeria-turma-sub-tabs-content">
                            <?php foreach ($projeto['dias'] as $dia): ?>
                                <div class="galeria-turma-sub-tab-content <?= $dia['ativo'] ? 'active' : '' ?>" id="sub-tab-<?= $dia['id'] ?>">
                                    <div class="galeria-turma-tab-inner">
                                        <div class="galeria-turma-tab-text">
                                            <h4><?= $dia['titulo'] ?></h4>
                                            <p><?= $dia['descricao'] ?></p>
                                            <?php if (!empty($dia['linkProjeto'])): ?>
                                                <div class="galeria-turma-botaoprojeto">
                                                    <button class="galeria-turma-btn" type="button"
                                                        onclick="window.location.href='<?= $dia['linkProjeto'] ?>'">
                                                        Ver Projeto
                                                    </button>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="galeria-turma-tab-image">
                                            <?php foreach (($dia['imagens'] ?? []) as $img): ?>
                                                <img src="<?= htmlspecialchars($img['url']) ?>" alt="<?= htmlspecialchars($img['alt']) ?>">
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Repositório do projeto -->
                        <div class="galeria-turma-repo-section">
                            <?php if (!empty($projeto['linkProjeto'])): ?>
                                <a href="<?= $projeto['linkProjeto'] ?>" target="_blank" class="galeria-turma-repo-link">
                                    Ver no GitHub
                                </a>
                            <?php else: ?>
                                <p>Link do repositório não disponível.</p>
                            <?php endif; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </section>

    <!-- ------------------- LISTAGEM DE ALUNOS ------------------- -->
    <section class="galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Alunos</h1>
        <div class="galeria-turma-container">
            <?php if (!empty($pessoasTurma)): ?>
                <?php foreach ($pessoasTurma as $pessoa): ?>
                    <?php if ($pessoa['perfil'] === 'aluno'): ?>
                        <?php include __DIR__ . "/../../componentes/users/card_pessoa.php"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum aluno encontrado para esta turma.</p>
            <?php endif; ?>
        </div>
    </section>

    <section class="galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Professores</h1>
        <div class="galeria-turma-container">
            <?php if (!empty($pessoasTurma)): ?>
                <?php foreach ($pessoasTurma as $pessoa): ?>
                    <?php if ($pessoa['perfil'] === 'professor'): ?>
                        <?php include __DIR__ . "/../../componentes/users/card_pessoa.php"; ?>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Nenhum professor encontrado para esta turma.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- ------------------- LISTAGEM DE PROFESSORES ------------------- -->

    <footer class="galeria-turma-footer">
        <?php require_once __DIR__ . "/../../componentes/users/footer.php"; ?>
    </footer>

    <!-- ------------------- SCRIPTS DE ABA / INTERAÇÃO ------------------- -->
    <script src="<?= '/../../../' . VARIAVEIS['DIR_JS'] ?>galeria-turma.js"></script>

</body>

</html>