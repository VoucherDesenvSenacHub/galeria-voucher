<?php
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../Model/EstatisticasModel.php";

headerComponent('Página Inicial');

try {
    $turmaModel = new TurmaModel();
    $turmas = $turmaModel->buscarTurmasParaGaleria();

    $estatisticasModel = new EstatisticasModel();
    $resultado = $estatisticasModel->getEstatisticas();

} catch (Exception $e) {
    $turmas = [];
    $resultado = ['alunos' => 0, 'projetos' => 0, 'polos' => 0];
    error_log("Erro na home.php: " . $e->getMessage());
}
?>

<body class="layout body-user">

    <section class="main-section layout-main">
    <?php
    $isAdmin = false;
    require_once __DIR__ . "/../../componentes/nav.php";
    ?>

        <main class="main-user">
            <section id="secao1">
                <?php require_once __DIR__ . "/../../componentes/users/mira.php"; ?>
    
                <canvas id="matrix-canvas"></canvas>
    
                <div class="content">
    
                    <div class="nome-voucher">
                        <img src="<?= Config::get('APP_URL') . Config::get('DIR_IMG') ?>utilitarios/nome.png" alt="Voucher Desenvolvedor">
                    </div>
    
                </div>
            </section>
    
            <section id="secao2" class="bg-gradient">
                <div class="container_card">
                    <div class="card">
                        <h2>O QUE É?</h2>
                        <p>
                            Qualifique-se para uma das áreas mais promissoras da atualidade com o Programa Voucher
                            Desenvolvedor.
                            Oferecemos vagas gratuitas para o curso Técnico em Desenvolvimento de Sistemas,
                            com carga horária de 1.200 horas.
                        </p>
                        <p>
                            Beneficie-se de uma experiência prática com interação direta
                            com empresas de tecnologia e, a partir do sexto mês, tenha a chance de conseguir um estágio
                            remunerado e se destacar no curso. Invista no seu futuro e abra portas para uma carreira de
                            sucesso em TI.
                        </p>
                    </div>
    
                    <div class="card">
                        <h2>PARA QUEM É?</h2>
                        <p>
                            Podem participar do processo seletivo pessoas com renda per capita familiar de até 2 salários
                            mínimos.
                        </p>
                        <p>
                            São elegíveis estudantes do ensino médio (1º, 2º ou 3º ano) matriculados em
                            instituições públicas de ensino em Mato Grosso do Sul, desde que estejam, no mínimo, no 2º ano.
                        </p>
                        <p>
                            Também podem participar aqueles que estão concluindo ou já concluíram o ensino médio, em
                            instituições públicas ou privadas.
                        </p>
                    </div>
    
                    <div class="card">
                        <h2>POR QUE FAZER?</h2>
                        <p>
                            A área de Tecnologia da Informação está em expansão, com uma alta demanda por profissionais de
                            Desenvolvimento de Sistemas.
                        </p>
                        <p>
                            Especializar-se nessa área oferece maior empregabilidade, inclusive
                            internacional, uma boa remuneração (a média é de R$ 2.221,00), e a possibilidade de novas
                            carreiras e desenvolvimento.
                        </p>
                        <p>
                            É um setor em constante crescimento, apresentando excelentes
                            perspectivas para quem busca se destacar.
                        </p>
                    </div>
                </div>
            </section>
            <section id="secao3" class="bg-gradient">
                <div class="container2">
                    <h1>SUA EVOLUÇÃO COMEÇA AQUI</h1>
                    <div class="stats">
                        <?php
                        $estatisticas = [
                            ['valor' => $resultado['alunos'] > 100 ? '+' . floor($resultado['alunos'] / 100) * 100 : $resultado['alunos'], 'label' => 'DE ALUNOS'],
                            ['valor' => $resultado['projetos'] > 10 ? '+' . floor($resultado['projetos'] / 10) * 10 : $resultado['projetos'], 'label' => 'PROJETOS'],
                            ['valor' => $resultado['polos'], 'label' => 'POLOS'],
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
    
            <section id="secao4" class="bg-gradient">
                <div class="call-to-action">
                    <p>SELECIONE UMA TURMA E <span>INSPIRE-SE</span></p>
                </div>
                <div class="poligono">
                    <?php if (!empty($turmas)): ?>
                        <div class="image-row">
                            <?php
                            $turmas_slice1 = array_slice($turmas, 0, 6);
                            foreach ($turmas_slice1 as $turma): ?>
                                <div class='image-turma'>
                                    <a href="<?= Config::get('APP_URL') . Config::get('DIR_USER') ?>galeria-turma.php?id=<?= htmlspecialchars($turma['turma_id']) ?>">
                                        <img src="<?= Config::get('APP_URL') . htmlspecialchars($turma['imagem_url']) ?>" alt="Imagem da <?= htmlspecialchars($turma['nome_turma']) ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
    
                        <div class="image-row">
                             <?php
                            $turmas_slice2 = array_slice($turmas, 6, 5);
                            foreach ($turmas_slice2 as $turma): ?>
                                <div class='image-turma'>
                                    <a href="<?= Config::get('APP_URL') . Config::get('DIR_USER') ?>galeria-turma.php?id=<?= htmlspecialchars($turma['turma_id']) ?>">
                                        <img src="<?= Config::get('APP_URL') . htmlspecialchars($turma['imagem_url']) ?>" alt="Imagem da <?= htmlspecialchars($turma['nome_turma']) ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
    
                        <div class="image-row">
                            <?php
                            $turmas_slice3 = array_slice($turmas, 11, 6);
                            foreach ($turmas_slice3 as $turma): ?>
                                <div class='image-turma'>
                                    <a href="<?= Config::get('APP_URL') . Config::get('DIR_USER') ?>galeria-turma.php?id=<?= htmlspecialchars($turma['turma_id']) ?>">
                                        <img src="<?= Config::get('APP_URL') . htmlspecialchars($turma['imagem_url']) ?>" alt="Imagem da <?= htmlspecialchars($turma['nome_turma']) ?>">
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <p style="text-align: center; font-size: 1.2rem; color: #fff;">Nenhuma turma encontrada.</p>
                    <?php endif; ?>
                </div>
            </section>
        </main>
        <?php require_once __DIR__ . "/./../../componentes/users/footer.php"; ?>
    </section>
    <script src="<?= Config::get('APP_URL') . Config::get('DIR_JS') . 'users/matrix.js' ?>"></script>
</body>