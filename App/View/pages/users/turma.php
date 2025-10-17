<?php

require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../componentes/head.php";

headerComponent('Turmas Voucher');

try {
    $turmaModel = new TurmaModel();
    $turmas = $turmaModel->buscarTurmasParaGaleria();
} catch (Exception $e) {
    $turmas = [];
    error_log("Erro ao buscar turmas: " . $e->getMessage());
}

$itensPorPagina = 12;
$paginaAtual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
$totalItens = count($turmas);
$totalPaginas = ceil($totalItens / $itensPorPagina);
$inicio = ($paginaAtual - 1) * $itensPorPagina;
$turmasPagina = array_slice($turmas, $inicio, $itensPorPagina);
?>

<body class="layout body-turma">
    <section class="main-section layout-main">
        <?php
            $isAdmin = false;
            require_once __DIR__ . "/./../../componentes/nav.php";
        ?>
        <main>
            <?php require_once __DIR__ . "/./../../componentes/users/mira.php"; ?>
    
            <div class="conteudotodo">
    
                <div class="turmatitulo">
                    <h1>TURMAS</h1>
                </div>
    
                <div class="cards" id="cards-container">
                    <?php foreach ($turmasPagina as $turma): ?>
                        <a href="<?= Config::get('APP_URL') . Config::get('DIR_USER') ?>galeria-turma.php?id=<?= $turma['turma_id'] ?>" class="card-turma">
                            <div class="card-content">
                                <h3 class="card-title"><?= htmlspecialchars($turma['nome_turma']) ?></h3>
                                <img class="card-image" src="<?= Config::get('APP_URL') . $turma['imagem_url'] ?>" alt="Imagem turma <?= htmlspecialchars($turma['nome_turma']) ?>">
                            </div>
                        </a>
                    <?php endforeach; ?>
                </div>
    
                <?php if ($totalPaginas > 1): ?>
                    <div class="paginacao-container">
                        <div class="paginacao">
                            <?php if ($paginaAtual > 1): ?>
                                <a href="?pagina=1" class="paginacao-item paginacao-primeira">
                                    <span class="material-symbols-outlined">first_page</span>
                                </a>
                                <a href="?pagina=<?= $paginaAtual - 1 ?>" class="paginacao-item paginacao-anterior">
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
                                <a href="?pagina=<?= $i ?>" class="paginacao-item <?= $i == $paginaAtual ? 'paginacao-ativa' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php endfor; ?>
    
                            <?php if ($fimPaginas < $totalPaginas): ?>
                                <span class="paginacao-ellipsis">...</span>
                            <?php endif; ?>
    
                            <?php if ($paginaAtual < $totalPaginas): ?>
                                <a href="?pagina=<?= $paginaAtual + 1 ?>" class="paginacao-item paginacao-proxima">
                                    <span class="material-symbols-outlined">chevron_right</span>
                                </a>
                                <a href="?pagina=<?= $totalPaginas ?>" class="paginacao-item paginacao-ultima">
                                    <span class="material-symbols-outlined">last_page</span>
                                </a>
                            <?php endif; ?>
                        </div>
    
                        <div class="paginacao-info">
                            <span>Página <?= $paginaAtual ?> de <?= $totalPaginas ?></span>
                            <span>(<?= $totalItens ?> turmas)</span>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
        <?php require_once __DIR__ . "/./../../componentes/users/footer.php"; ?>
    </section>
</body>
</html>