<?php
require_once __DIR__ . "/../../componentes/head.php";
require __DIR__ . "/../../../Model/AlunoModel.php";

$alunoModel = new AlunoModel();
$alunos = $alunoModel->buscarPorTurma(25);

$pessoasTurma = [];
$pessoasTurma = array_merge($pessoasTurma, $alunos);

headerComponent('Desenvolvedores');
?>

<body class="layout body_dev">
    <section class="main-section layout-main">
        <header class="nav-head header_dev">
            <?php
            // Aqui você passa a função JS no parâmetro do botão
            buttonComponent('primary', 'VOLTAR', false, "javascript:window.history.back()", null, null, "dev-no-button");
            ?>
            <div class="titulo-pagina">
                <h1 class="titulodev">DESENVOLVEDORES</h1>
            </div>
        </header>
        <main class="main_dev">
            <?php require_once __DIR__ . "/../../componentes/users/mira.php"; ?>
    
            <section class="galeria-turma-cardss">
                <h1 class="galeria-turma-h1">Alunos</h1>
                <div class="galeria-turma-container">
                    <?php foreach ($pessoasTurma as $pessoa): ?>
                        <?php include __DIR__ . "/../../componentes/users/cardPessoa.php"; ?>
                    <?php endforeach; ?>
                </div>
            </section>
    
        </main>
        <div class="algo">
            <div id="game-overlay" class="easter-egg-overlay">
                <div id="game-container" class="easter-egg-container">
                    <div id="score-board">PONTOS: 0</div>
                    <canvas id="gameCanvas"></canvas>
                    <div id="start-screen"><h2>Clique para Iniciar</h2></div>
                    <div id="game-over-screen">
                        <h2>pausa para café familia.</h2>
                        <p>Sua pontuação final: <span id="final-score">0</span></p>
                        <input type="text" id="player-name" placeholder="Digite seu nome (3 letras)" maxlength="3">
                        <button id="save-score-btn">Salvar</button>
                    </div>
                    <div id="leaderboard">
                        <h3>RANKING</h3>
                        <ol id="high-scores-list"></ol>
                    </div>
                </div>
                <div id="game-instructions">Use as setas para mover. Aperte 'ESC' para sair.</div>
                <div id="touch-controls">
                    <div id="btn-up" class="touch-btn">▲</div>
                    <div id="btn-left" class="touch-btn">◄</div>
                    <div id="btn-right" class="touch-btn">►</div>
                    <div id="btn-down" class="touch-btn">▼</div>
                </div>
                </div>

                <div id="thiago-letter-modal" class="easter-egg-overlay">
                    <div class="easter-egg-container">
                        <h2>Ao Professor Thiago,</h2>
                        <p>Nós, alunos da Turma 146 do programa Voucher Desenvolvedor do Senac, escrevemos esta carta como um sincero e profundo agradecimento. Desde o início de nossa jornada em março de 2024, até a reta final em janeiro de 2026, sua presença constante e seu empenho incansável foram o nosso alicerce.</p>
                        <p>Em um curso onde foi natural a rotação de docentes, você foi a nossa âncora. Enquanto outros professores entraram e saíram, você permaneceu, tornando-se uma referência de estabilidade e dedicação que jamais esqueceremos.</p>
                        <p>Lembramos com clareza dos primeiros dias, quando a turma estava cheia de expectativas e você nos guiou pelos conceitos fundamentais de desenvolvimento de software: desde a importância do briefing até a lógica dos fluxogramas e a estrutura do pseudocódigo com Python.</p>
                        <p>Avançamos juntos, dominando as bases do HTML e CSS para dar vida às nossas interfaces, e mergulhamos no universo do Banco de Dados. Foi com você que aprendemos, na prática, a realidade do desenvolvimento ágil, trabalhando em equipe e nos comunicando na Daily como verdadeiros profissionais, com as valiosas lições sobre os papéis de Product Owner (PO) e Scrum Master.</p>
                        <p>Passamos pela complexidade do PHP e Banco de Dados, e encerramos este ciclo aprendendo sobre testes e deploy, prontos para colocar nossos projetos no ar.</p>
                        <p>Professor Thiago, você não apenas transmitiu conhecimento técnico; você nos ensinou a ter perseverança, a trabalhar em conjunto e, o mais importante, a não desistir diante dos desafios do nosso Projeto Integrador (PI).</p>
                        <p>Somos gratos por toda a paciência, pela paixão em ensinar e por nos guiar de forma tão dedicada ao longo destes quase dois anos. Você contribuiu imensamente para a nossa formação profissional e pessoal.</p>
                        <p>Desejamos muito sucesso em sua carreira e vida, sabendo que cada aluno da Turma 146 leva consigo um pouco do seu legado.</p>
                        <div class="signature">
                            <p>Com a mais profunda gratidão,<br>Turma 146 - Voucher Desenvolvedor<br>Senac, Janeiro de 2026</p>
                        </div>
                        <button id="close-letter-btn">Fechar</button>
                    </div>
                </div>
            </div>
        <?php require_once __DIR__ . "/./../../componentes/users/footer.php" ?>

    </section>

    <script src="<?php echo Config::get('APP_URL') . Config::get('DIR_JS') . 'easter-egg.js'; ?>"></script>

</body>
</html>
