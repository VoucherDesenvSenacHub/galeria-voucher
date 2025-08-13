<?php

require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../componentes/head.php";

headerComponent('Turmas Voucher')
    ?>

<body class="body-turma">

    <?php
    $isAdmin = false; // Para páginas de users
    require_once __DIR__ . "/./../../componentes/nav.php"
        ?>
    <?php require_once __DIR__ . "/./../../componentes/users/mira.php" ?>

    <main>

        <div class="conteudotodo">

            <div class="turmatitulo">
                <h1>TURMAS </h1>
            </div>

            <!-- Cards das Turmas -->
            <?php
            // 2. BUSCA DAS TURMAS NO BANCO DE DADOS
            try {
                $turmaModel = new TurmaModel();
                // Usei a função que criamos, que busca apenas turmas com imagem
                $turmas = $turmaModel->buscarTurmasParaGaleria();
            } catch (Exception $e) {
                // Se houver erro na conexão ou consulta, a página não quebra
                $turmas = [];
                error_log("Erro ao buscar turmas: " . $e->getMessage());
            }

            // var_dump($turmas);

            $itensPorPagina = 12; // Cards por página
            $paginaAtual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
            $totalItens = count($turmas);
            $totalPaginas = ceil($totalItens / $itensPorPagina);
            $inicio = ($paginaAtual - 1) * $itensPorPagina;
            $turmasPagina = array_slice($turmas, $inicio, $itensPorPagina);
            ?>

            <div class="cards" id="cards-container">
                <?php foreach ($turmasPagina as $turmas['nome_turma']) { ?>
                    <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER']; ?>galeria-turma.php"
                        class="card-turma">
                        <div class="card-content">
                            <h3 class="card-title">TURMA<?php echo $turmas['nome_turma']; ?></h3>
                            <img class="card-image"
                                src="<?php echo VARIAVEIS['APP_URL'] . $turmas['imagem_url'] ?>"
                                alt="Imagem turma <?php echo $turmas['nome_turma']; ?>">
                        </div>
                    </a>
                <?php } ?>
            </div>

            <!-- Paginação -->
            <?php if ($totalPaginas > 1): ?>
                <div class="paginacao-container">
                    <div class="paginacao">
                        <?php if ($paginaAtual > 1): ?>
                            <a href="?pagina=1" class="paginacao-item paginacao-primeira">
                                <span class="material-symbols-outlined">first_page</span>
                            </a>
                            <a href="?pagina=<?php echo $paginaAtual - 1; ?>" class="paginacao-item paginacao-anterior">
                                <span class="material-symbols-outlined">chevron_left</span>
                            </a>
                        <?php endif; ?>

                        <?php
                        $inicioPaginas = max(1, $paginaAtual - 2);
                        $fimPaginas = min($totalPaginas, $paginaAtual + 2);

                        if ($inicioPaginas > 1): ?>
                            <span class="paginacao-ellipsis">...</span>
                        <?php endif; ?>

                        <?php for ($i = $inicioPaginas; $i <= $fimPaginas; $i++): ?>
                            <a href="?pagina=<?php echo $i; ?>"
                                class="paginacao-item <?php echo $i == $paginaAtual ? 'paginacao-ativa' : ''; ?>">
                                <?php echo $i; ?>
                            </a>
                        <?php endfor; ?>

                        <?php if ($fimPaginas < $totalPaginas): ?>
                            <span class="paginacao-ellipsis">...</span>
                        <?php endif; ?>

                        <?php if ($paginaAtual < $totalPaginas): ?>
                            <a href="?pagina=<?php echo $paginaAtual + 1; ?>" class="paginacao-item paginacao-proxima">
                                <span class="material-symbols-outlined">chevron_right</span>
                            </a>
                            <a href="?pagina=<?php echo $totalPaginas; ?>" class="paginacao-item paginacao-ultima">
                                <span class="material-symbols-outlined">last_page</span>
                            </a>
                        <?php endif; ?>
                    </div>

                    <div class="paginacao-info">
                        <span>Página <?php echo $paginaAtual; ?> de <?php echo $totalPaginas; ?></span>
                        <span>(<?php echo $totalItens; ?> turmas)</span>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>
    <?php require_once __DIR__ . "/./../../componentes/users/footer.php" ?>
</body>

</html>