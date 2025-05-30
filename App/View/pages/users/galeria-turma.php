<?php
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>

<body class="galeria-turma-body">
    <header class="galeria-turma-header">
        <?php require_once __DIR__ . "/./../../componentes/users/nav.php" ?>
        <?php require_once __DIR__ . "/./../../componentes/users/mira.php" ?>
    </header>
    <!-- parte das linhas -->
    <section class="galeria-turma-section galeria-turma-projeto">
        <h1 class="galeria-turma-h1">Projetos da turma</h1>
    </section>
    <section class="galeria-turma-section galeria-turma-galeria">
        <h2>Galeria E-Commerce</h2>
    </section>
    <section class="galeria-turma-section galeria-turma-senac">
        <h1 class="galeria-turma-h1">Senac Hub Academy</h1>
        <h1 class="galeria-turma-h1">Campo Grande - MS</h1>
    </section>

    <section class="galeria-turma-section galeria-turma-dia">
        <img class="galeria-turma-imagem-direita"
            src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
        <div class="galeria-turma-margin-top-left-turma-xx">
            <h2>TURMA XX</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Reprehenderit, quod amet sint ut debitis optio
                quaerat rerum qui soluta quibusdam suscipit temporibus, aliquam ducimus distinctio hic dolorem, corporis
                itaque odio?</p>
        </div>
    </section>

    <div class="galeria-turma-binarynumber"></div>

    <section class="galeria-turma-section galeria-turma-dia">
        <div>
            <h2>DIA I</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Autem, blanditiis sequi, voluptas nam ut dicta
                maxime dignissimos, est cupiditate esse iste aliquam tempora quos vero recusandae. Facilis, iste illo!
                Unde.</p>
        </div>
        <img class="galeria-turma-imagem-diaI"
            src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
    </section>

    <section class="galeria-turma-section galeria-turma-dia">
        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
        <div class="galeria-turma-margin-top-left-dia-p">
            <h2>DIA P</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Rem, esse. Cupiditate officia ut cum illo
                doloremque quibusdam fuga natus necessitatibus veritatis eligendi facere, repellat aliquam eveniet aut
                ex blanditiis perspiciatis!</p>
        </div>
    </section>

    <section class="galeria-turma-section galeria-turma-dia">
        <div class="galeria-turma-margin-top-right-dia-e">
            <h2>DIA E</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Consectetur nobis a laboriosam error nihil
                placeat cum libero sapiente magni, voluptatum commodi accusamus repudiandae repellendus suscipit! Aut
                quo qui inventore debitis.</p>
        </div>
        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
    </section>

    <section class="galeria-turma-section galeria-turma-dia">
        <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>turmas/turma-galeria.png">
        <div class="galeria-turma-margin-top-left-projeto-xx">
            <h2>PROJETO XX</h2>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. In ad iusto omnis reiciendis dolor eos illo
                quas. Ipsa modi amet officiis nulla veniam dolorem consequuntur pariatur minima. Neque, impedit
                voluptatum!</p>
            <div class="galeria-turma-botaoprojeto">
                <button class="galeria-turma-btn" type="button">Ver Projeto</button>
            </div>
        </div>
    </section>

    <section class="galeria-turma-section galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Alunos</h1>
        <li>
            <div class="galeria-turma-container">
                <?php for ($i = 0; $i <= 14; $i++) { ?>
                    <?php require __DIR__ . "/./../../componentes/users/card_desenvolvedores.php" ?>
                <?php } ?>
            </div>
    </section>

    <section class="galeria-turma-section galeria-turma-cardss">
        <h1 class="galeria-turma-h1">Professores</h1>
        <div class="galeria-turma-container">
            <?php for ($i = 0; $i <= 14; $i++) { ?>
                <?php require __DIR__ . "/./../../componentes/users/card_desenvolvedores.php" ?>
            <?php } ?>
        </div>
    </section>

    <footer class="galeria-turma-footer">
        <?php require_once __DIR__ . "/./../../componentes/users/footer.php" //componente do rodapé ?>
    </footer>

</body>

</html>