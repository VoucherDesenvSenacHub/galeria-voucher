<?php
require_once __DIR__ . "/../../componentes/head.php";

// Define o título da página 
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
            <h3 class="galeria-turma-h3"><?= $polo?></h3>
            <h3 class="galeria-turma-h3"><?= $cidade?></h3>
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
                                        <?php if ($dia['ordem'] === 'imagem-direita'): ?>
                                            <div class="galeria-turma-tab-text <?= $dia['divClass'] ?>">
                                                <h4><?= $dia['titulo'] ?></h4>
                                                <p><?= $dia['descricao'] ?></p>
                                                <?php if (!empty($dia['botaoProjeto'])): ?>
                                                    <div class="galeria-turma-botaoprojeto">
                                                        <button class="galeria-turma-btn" type="button"
                                                            onclick="window.location.href='<?= $dia['linkProjeto'] ?>'">
                                                            Ver Projeto
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="galeria-turma-tab-image">
                                                <img src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . $dia['imagem'] ?>"
                                                    alt="<?= $dia['titulo'] ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="galeria-turma-tab-image">
                                                <img src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . $dia['imagem'] ?>"
                                                    alt="<?= $dia['titulo'] ?>">
                                            </div>
                                            <div class="galeria-turma-tab-text <?= $dia['divClass'] ?>">
                                                <h4><?= $dia['titulo'] ?></h4>
                                                <p><?= $dia['descricao'] ?></p>
                                                <?php if (!empty($dia['botaoProjeto'])): ?>
                                                    <div class="galeria-turma-botaoprojeto">
                                                        <button class="galeria-turma-btn" type="button"
                                                            onclick="window.location.href='<?= $dia['linkProjeto'] ?>'">
                                                            Ver Projeto
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Repositório do projeto -->
                        <div class="galeria-turma-repo-section">
                            <h4>Repositório do Projeto</h4>
                            <?php if (!empty($projeto['linkRepositorio'])): ?>
                                <a href="<?= $projeto['linkRepositorio'] ?>" target="_blank" class="galeria-turma-repo-link">
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
            <?php
            foreach ($alunos as $aluno) {
                require __DIR__ . "/../../componentes/users/card_desenvolvedores.php";
            }
            ?>
        </div>
    </section>

    <!-- ------------------- LISTAGEM DE PROFESSORES ------------------- -->
    <section class="galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Professores</h1>
        <div class="galeria-turma-container">
            <?php
            foreach ($orientadores as $orientador) {
                require __DIR__ . "/../../componentes/users/card_orientadores.php";
            }
            ?>
        </div>
    </section>

    <footer class="galeria-turma-footer">
        <?php require_once __DIR__ . "/../../componentes/users/footer.php"; ?>
    </footer>

    <!-- ------------------- SCRIPTS DE ABA / INTERAÇÃO ------------------- -->
    <script src="<?= '/../../../' . VARIAVEIS['DIR_JS'] ?>galeria-turma.js"></script>

</body>

</html>