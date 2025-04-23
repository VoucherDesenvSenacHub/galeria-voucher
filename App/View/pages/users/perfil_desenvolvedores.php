<?php 
require_once __DIR__ . "/../../../Config/env.php";
// require_once __DIR__ . "/../../componentes/head.php";






?>
<body class="body_dev">
    <header class="header_dev">
        <button href="#" class="voltar">VOLTAR</button>
        <div class="titulo-pagina">
            <h1 class="titulodev">DESENVOLVEDORES</h1>
        </div>
    </header>
    <main class="main_dev">
    <?php require_once __DIR__ . "/./../../componentes/users/mira.php"; //componente da mira ?>
        <div class="container">
       <?php require_once __DIR__ . "/../../componentes/head.php";?>
            <?php
            // Defina o número de cards que você quer exibir
            $numeroDeCards = 16;

            for ($i = 0; $i < $numeroDeCards; $i++) {
                require __DIR__ . "/../../../View/componentes/users/card_desenvolvedores.php";
            }
            ?>
        </div>
    </main>

    <div class="textofinal">
    <?php require_once __DIR__ . "/./../../componentes/users/footer.php"; //componente da mira ?>
    </div>
</body>
</html>