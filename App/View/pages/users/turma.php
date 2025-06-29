<?php 

require_once __DIR__ . "/../../componentes/head.php";

headerComponent('Turmas Voucher')
?>
<body class="body-turma">

    <?php require_once __DIR__ . "/./../../componentes/users/nav.php" ?>
    <?php require_once __DIR__ . "/./../../componentes/users/mira.php" ?>

    <main>
            
        <div class="conteudotodo">

            <div class="turmatitulo">
                <h1>TURMAS </h1>
            </div>
        
        
            <!-- Cards das Turmas -->
            <?php
                $turmas = range(130, 177);
                $limiteVisiveis = 32; // quantidade de turmas que aparecem inicialmente
            ?>
            <div class="cards" id="cards-container">
                <?php foreach ($turmas as $index => $turmaNumero) {
                    $extraClass = ($index >= $limiteVisiveis) ? 'extra' : '';
                ?>
                    <a href="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_USER']; ?>galeria-turma.php" class="card-turma <?php echo $extraClass; ?>">
                        <div class="card-content">
                            <h3 class="card-title">TURMA <?php echo $turmaNumero; ?></h3>
                            <img class="card-image" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG']; ?>turmas/turma.jpg" alt="Imagem turma <?php echo $turmaNumero; ?>">
                        </div>
                    </a>
                <?php } ?>
            </div>
        </div>

        <div class = "ver-mais-cont">
            <div class="vermais" id="vermais">
                <h3>VER MAIS</h3>
                <span class="material-symbols-outlined" id="arrow-icon">
                    arrow_downward
                </span>
            </div>
        </div>   
    </main>  
    <?php require_once __DIR__ . "/./../../componentes/users/footer.php" ?>
    <script src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_JS'] ?>alunos/turma.js" defer></script>
</body>
</html>
