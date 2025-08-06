<?php
require_once __DIR__ . "/../../componentes/head.php";
// 1. INCLUSÃO DOS ARQUIVOS NECESSÁRIOS
require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../Model/EstatisticasModel.php";

headerComponent('Página Inicial');

// 2. BUSCA DAS TURMAS E ESTATÍSTICAS
try {
    $turmaModel = new TurmaModel();
    $turmas = $turmaModel->buscarTurmasParaGaleria();
    
    $estatisticasModel = new EstatisticasModel();
    $resultado = $estatisticasModel->getEstatisticas();

} catch (Exception $e) {
    // Se houver erro, a página não quebra
    $turmas = [];
    $resultado = ['alunos' => 0, 'projetos' => 0, 'polos' => 0];
    error_log("Erro na home.php: " . $e->getMessage());
}
?>

<body class="body-user">
    <?php
        $isAdmin = false;
        require_once __DIR__ . "/../../componentes/nav.php";
    ?>
    <?php require_once __DIR__ . "/../../componentes/users/mira.php"; ?>

    <main class="main-user">
        <section id="secao1">
            </section>
        <section id="secao2">
            </section>
        <section id="secao3">
             <div class="container2">
                <h1>SUA EVOLUÇÃO COMEÇA AQUI</h1>
                <div class="stats">
                    <?php
                    $numAlunos = $resultado['alunos'];
                    $numProjetos = $resultado['projetos'];
                    $numPolos = $resultado['polos'];

                    $estatisticas = [
                        ['valor' => $numAlunos > 100 ? '+' . floor($numAlunos / 100) * 100 : $numAlunos, 'label' => 'DE ALUNOS'],
                        ['valor' => $numProjetos > 10 ? '+' . floor($numProjetos / 10) * 10 : $numProjetos, 'label' => 'PROJETOS'],
                        ['valor' => $numPolos, 'label' => 'POLOS'],
                        ['valor' => '1200', 'label' => 'CURSO COM HORAS']
                    ];
                    
                    foreach ($estatisticas as $estatistica) {
                        echo "<div>
                                <span>{$estatistica['valor']}</span>
                                <p>{$estatistica['label']}</p>
                            </div>";
                    }
                    ?>
                </div>
            </div>
        </section>

        <section id="secao4">
            <div class="call-to-action">
                <p>SELECIONE UMA TURMA E <span>INSPIRE-SE</span></p>
            </div>
            <div class="poligono">
                <?php if (!empty($turmas)): ?>
                    <?php
                        // Divide as turmas em grupos para as linhas da galeria
                        $linhasDaGaleria = array_chunk($turmas, 6);
                    ?>
                    <?php foreach ($linhasDaGaleria as $linha): ?>
                        <div class="image-row">
                            <?php foreach ($linha as $turma): ?>
                                <div class='image-turma'>
                                    <a href="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER'] ?>galeria-turma.php?id=<?= htmlspecialchars($turma['turma_id']) ?>">
                                        <img src="<?= VARIAVEIS['APP_URL'] . htmlspecialchars($turma['imagem_url']) ?>" alt="Imagem da <?= htmlspecialchars($turma['nome_turma']) ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="text-align: center; color: white;">Nenhuma turma com imagem encontrada para exibir na galeria.</p>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <?php require_once __DIR__ . "/../../componentes/users/footer.php"; ?>
</body>