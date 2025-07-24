<?php
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";

headerComponent('Galeria da Turma');

// Lista de projetos principais (escalável para futuros projetos)
$projetosTurmas = [
    [
        'id' => 'projeto-1',
        'titulo' => 'PROJETO 1',
        'descricao' => 'Primeiro projeto desenvolvido pela turma, focado em fundamentos de desenvolvimento web e design responsivo.',
        'cor_tema' => '#AEFF40',
        'subtopicos' => [
            [
                'id' => 'projeto1-dia-i',
                'titulo' => 'DIA I',
                'descricao' => 'Início do Projeto 1: Planejamento e definição de requisitos. Nesta fase, os alunos aprenderam sobre análise de requisitos, criação de wireframes e definição da arquitetura do projeto.',
                'imagem' => 'turmas/turma-galeria.png',
                'ordem' => 'imagem-direita',
                'divClass' => 'galeria-turma-margin-top-left-projeto1-dia-i'
            ],
            [
                'id' => 'projeto1-dia-p',
                'titulo' => 'DIA P',
                'descricao' => 'Desenvolvimento do Projeto 1: Implementação das funcionalidades principais. Os estudantes trabalharam na codificação das features core, integração de APIs e desenvolvimento do frontend.',
                'imagem' => 'turmas/turma-galeria.png',
                'ordem' => 'imagem-esquerda',
                'divClass' => 'galeria-turma-margin-top-right-projeto1-dia-p'
            ],
            [
                'id' => 'projeto1-dia-e',
                'titulo' => 'DIA E',
                'descricao' => 'Finalização do Projeto 1: Testes, otimização e deploy. Fase dedicada aos testes unitários, correção de bugs, otimização de performance e preparação para produção.',
                'imagem' => 'turmas/turma-galeria.png',
                'ordem' => 'imagem-direita',
                'divClass' => 'galeria-turma-margin-top-left-projeto1-dia-e'
            ],
            [
                'id' => 'projeto1-projeto-xx',
                'titulo' => 'PROJETO XX',
                'descricao' => 'Apresentação final do Projeto 1: Demonstração completa das funcionalidades desenvolvidas, documentação técnica e apresentação para stakeholders.',
                'imagem' => 'turmas/turma-galeria.png',
                'ordem' => 'imagem-esquerda',
                'divClass' => 'galeria-turma-margin-top-right-projeto1-final',
                'botaoProjeto' => true,
                'linkProjeto' => '#projeto1-demo'
            ]
        ]
    ],
    [
        'id' => 'projeto-2',
        'titulo' => 'PROJETO 2',
        'descricao' => 'Segundo projeto da turma, com foco em tecnologias avançadas, integração de sistemas e metodologias ágeis.',
        'cor_tema' => '#AEFF40',
        'subtopicos' => [
            [
                'id' => 'projeto2-dia-i',
                'titulo' => 'DIA I',
                'descricao' => 'Kickoff do Projeto 2: Pesquisa de mercado e prototipagem. Início com análise competitiva, definição de personas, criação de protótipos interativos e validação de conceitos.',
                'imagem' => 'turmas/turma-galeria.png',
                'ordem' => 'imagem-direita',
                'divClass' => 'galeria-turma-margin-top-left-projeto2-dia-i'
            ],
            [
                'id' => 'projeto2-dia-p',
                'titulo' => 'DIA P',
                'descricao' => 'Sprint de desenvolvimento do Projeto 2: Implementação de features avançadas. Desenvolvimento usando metodologias ágeis, integração com microserviços e implementação de funcionalidades complexas.',
                'imagem' => 'turmas/turma-galeria.png',
                'ordem' => 'imagem-esquerda',
                'divClass' => 'galeria-turma-margin-top-right-projeto2-dia-p'
            ],
            [
                'id' => 'projeto2-dia-e',
                'titulo' => 'DIA E',
                'descricao' => 'Refinamento do Projeto 2: Polimento e integração final. Foco na experiência do usuário, testes de usabilidade, integração contínua e preparação para lançamento.',
                'imagem' => 'turmas/turma-galeria.png',
                'ordem' => 'imagem-direita',
                'divClass' => 'galeria-turma-margin-top-left-projeto2-dia-e'
            ],
            [
                'id' => 'projeto2-projeto-xx',
                'titulo' => 'PROJETO XX',
                'descricao' => 'Lançamento do Projeto 2: Deploy em produção e monitoramento. Implementação em ambiente de produção, configuração de monitoramento, análise de métricas e coleta de feedback.',
                'imagem' => 'turmas/turma-galeria.png',
                'ordem' => 'imagem-esquerda',
                'divClass' => 'galeria-turma-margin-top-right-projeto2-final',
                'botaoProjeto' => true,
                'linkProjeto' => '#projeto2-demo'
            ]
        ]
    ]
];
?>

<body class="galeria-turma-body">
    <header class="galeria-turma-header">
        <?php
        $isAdmin = false;
        require_once __DIR__ . "/../../componentes/nav.php";
        require_once __DIR__ . "/../../componentes/users/mira.php";
        ?>
    </header>

    <section class="galeria-turma-section galeria-turma-projeto">
        <h1 class="galeria-turma-h1 projetos-turma">Projetos da turma</h1>


        <section class="galeria-turma-senac">
            <h3 class="galeria-turma-h3">Senac Hub Academy</h3>
            <h3 class="galeria-turma-h3">Campo Grande - MS</h3>
        </section>

        <section class="galeria-turma-tab-inner ">
            <img class="galeria-turma-imagem-direita"
                src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
            <div class="galeria-turma-margin-top-left-projeto1-dia-i">
                <h2>TURMA 146</h2>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, quod amet sint ut debitis optio
                    quaerat rerum qui soluta quibusdam suscipit temporibus, aliquam ducimus distinctio hic dolorem, corporis
                    itaque odio?</p>
            </div>
        </section>

        <!-- Sistema de Abas Aninhadas para Projetos -->
        <section class="galeria-turma-section galeria-turma-galeria projetos-turma">
            <h2>Galeria de Projetos</h2>

            <!-- Navegação das Abas Principais (Projetos) -->
            <div class="galeria-turma-main-tabs-nav">
                <?php foreach ($projetosTurmas as $indexProjeto => $projeto): ?>
                    <a class="galeria-turma-main-tab-btn <?= $indexProjeto === 0 ? 'active' : '' ?>"
                        data-projeto="<?= $projeto['id'] ?>"
                        style="--cor-tema: <?= $projeto['cor_tema'] ?>">
                        <?= $projeto['titulo'] ?>
                    </a>
                <?php endforeach; ?>
            </div>

            <!-- Conteúdo dos Projetos -->
            <div class="galeria-turma-main-tabs-content">
                <?php foreach ($projetosTurmas as $indexProjeto => $projeto): ?>
                    <div class="galeria-turma-main-tab-content <?= $indexProjeto === 0 ? 'active' : '' ?>"
                        id="main-tab-<?= $projeto['id'] ?>">

                        <!-- Descrição do Projeto -->
                        <div class="galeria-turma-projeto-intro">
                            <h3><?= $projeto['titulo'] ?></h3>
                            <p><?= $projeto['descricao'] ?></p>
                        </div>

                        <!-- Navegação das Sub-abas (Dia I, Dia P, etc.) -->
                        <div class="galeria-turma-sub-tabs-nav">
                            <?php foreach ($projeto['subtopicos'] as $indexSub => $subtopico): ?>
                                <button class="galeria-turma-sub-tab-btn <?= $indexSub === 0 ? 'active' : '' ?>"
                                    data-subtab="<?= $subtopico['id'] ?>"
                                    data-projeto="<?= $projeto['id'] ?>">
                                    <?= $subtopico['titulo'] ?>
                                </button>
                            <?php endforeach; ?>
                        </div>

                        <!-- Conteúdo das Sub-abas -->
                        <div class="galeria-turma-sub-tabs-content">
                            <?php foreach ($projeto['subtopicos'] as $indexSub => $subtopico): ?>
                                <div class="galeria-turma-sub-tab-content <?= $indexSub === 0 ? 'active' : '' ?>"
                                    id="sub-tab-<?= $subtopico['id'] ?>">
                                    <div class="galeria-turma-tab-inner">
                                        <?php if ($subtopico['ordem'] === 'imagem-direita'): ?>
                                            <div class="galeria-turma-tab-text <?= $subtopico['divClass'] ?>">
                                                <h4><?= $subtopico['titulo'] ?></h4>
                                                <p><?= $subtopico['descricao'] ?></p>
                                                <?php if (!empty($subtopico['botaoProjeto'])): ?>
                                                    <div class="galeria-turma-botaoprojeto">
                                                        <button class="galeria-turma-btn"
                                                            type="button"
                                                            onclick="window.location.href='<?= $subtopico['linkProjeto'] ?>'">
                                                            Ver Projeto
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="galeria-turma-tab-image">
                                                <img src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . $subtopico['imagem'] ?>"
                                                    alt="<?= $subtopico['titulo'] ?>">
                                            </div>
                                        <?php else: ?>
                                            <div class="galeria-turma-tab-image">
                                                <img src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . $subtopico['imagem'] ?>"
                                                    alt="<?= $subtopico['titulo'] ?>">
                                            </div>
                                            <div class="galeria-turma-tab-text <?= $subtopico['divClass'] ?>">
                                                <h4><?= $subtopico['titulo'] ?></h4>
                                                <p><?= $subtopico['descricao'] ?></p>
                                                <?php if (!empty($subtopico['botaoProjeto'])): ?>
                                                    <div class="galeria-turma-botaoprojeto">
                                                        <button class="galeria-turma-btn"
                                                            type="button"
                                                            onclick="window.location.href='<?= $subtopico['linkProjeto'] ?>'">
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
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </section>
    <div class="galeria-turma-binarynumber"></div>

    <section class="galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Alunos</h1>
        <li>
            <div class="galeria-turma-container">
                <?php
                require __DIR__ . "/../../componentes/users/desenvolvedores.php";
                foreach ($desenvolvedores as $dev) {
                    require __DIR__ . "/../../componentes/users/card_desenvolvedores.php";
                }
                ?>
            </div>
        </li>
    </section>

    <section class="galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Professores</h1>
        <div class="galeria-turma-container">
            <?php
            require __DIR__ . "/../../componentes/users/desenvolvedores.php";
            foreach ($orientadores as $orientador) {
                require __DIR__ . "/../../componentes/users/card_orientadores.php";
            }
            ?>
        </div>
    </section>

    <footer class="galeria-turma-footer">
        <?php require_once __DIR__ . "/../../componentes/users/footer.php"; ?>
    </footer>

    <!-- JavaScript para funcionalidade das abas aninhadas -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mainTabButtons = document.querySelectorAll('.galeria-turma-main-tab-btn');
            const mainTabContents = document.querySelectorAll('.galeria-turma-main-tab-content');

            // Objeto para guardar a sub-aba ativa por projeto
            const subTabAtivaPorProjeto = {};

            // Inicialização
            mainTabButtons.forEach((button, index) => {
                const targetProject = button.getAttribute('data-projeto');
                if (index === 0) subTabAtivaPorProjeto[targetProject] = document.querySelector(`#main-tab-${targetProject} .galeria-turma-sub-tab-btn.active`)?.getAttribute('data-subtab');
            });

            // Lógica de abas principais (ainda com clique)
            mainTabButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const targetProject = this.getAttribute('data-projeto');

                    mainTabButtons.forEach(btn => btn.classList.remove('active'));
                    mainTabContents.forEach(content => content.classList.remove('active'));

                    this.classList.add('active');
                    const activeMainContent = document.getElementById('main-tab-' + targetProject);
                    activeMainContent.classList.add('active');

                    // Reiniciar sub-aba para a primeira
                    const projectSubTabs = activeMainContent.querySelectorAll('.galeria-turma-sub-tab-btn');
                    const projectSubContents = activeMainContent.querySelectorAll('.galeria-turma-sub-tab-content');

                    projectSubTabs.forEach((btn, index) => {
                        const isFirst = index === 0;
                        btn.classList.toggle('active', isFirst);
                        projectSubContents[index].classList.toggle('active', isFirst);
                        if (isFirst) {
                            subTabAtivaPorProjeto[targetProject] = btn.getAttribute('data-subtab');
                        }
                    });
                });
            });

            // Hover nas sub-abas
            const allSubTabs = document.querySelectorAll('.galeria-turma-sub-tab-btn');

            allSubTabs.forEach(button => {
                const subtabId = button.getAttribute('data-subtab');
                const projectId = button.getAttribute('data-projeto');
                const parentContent = document.getElementById('main-tab-' + projectId);

                const buttons = parentContent.querySelectorAll('.galeria-turma-sub-tab-btn');
                const contents = parentContent.querySelectorAll('.galeria-turma-sub-tab-content');

                button.addEventListener('mouseenter', () => {
                    buttons.forEach(btn => btn.classList.remove('active'));
                    contents.forEach(content => content.classList.remove('active'));

                    button.classList.add('active');
                    document.getElementById('sub-tab-' + subtabId).classList.add('active');
                });

                button.addEventListener('mouseleave', () => {
                    // Voltar para sub-aba ativa
                    const ativaId = subTabAtivaPorProjeto[projectId];
                    buttons.forEach(btn => {
                        btn.classList.toggle('active', btn.getAttribute('data-subtab') === ativaId);
                    });
                    contents.forEach(content => {
                        content.classList.toggle('active', content.id === 'sub-tab-' + ativaId);
                    });
                });

                // Atualiza aba ativa ao clique
                button.addEventListener('click', () => {
                    subTabAtivaPorProjeto[projectId] = subtabId;
                });
            });
        });
    </script>

</body>

</html>