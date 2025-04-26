<?php 
require_once __DIR__ . "/../../../Config/env.php"; // 
require_once __DIR__ . "/../../componentes/head.php"; // importa as fontes

// botão voltar
?>
<body class="body_dev">
    <header class="header_dev">
    <?php buttonComponent('primary', 'VOLTAR'); ?> 
        <div class="titulo-pagina">
            <h1 class="titulodev">DESENVOLVEDORES</h1>
        </div>
    </header>
    <main class="main_dev">
    <?php require_once __DIR__ . "/./../../componentes/users/mira.php"; //componente da mira ?>
        <div class="container">
            <?php require_once __DIR__ . "/../../componentes/head.php";?> 
            <?php
            
            $numeroDeCards = 16; // Define o número de cards que você quer exibir

            for ($i = 0; $i < $numeroDeCards; $i++) { 
                require __DIR__ . "/../../../View/componentes/users/card_desenvolvedores.php"; // importa os cards
            }
            ?>
        </div>
    </main>
    <div class="textofinal">
    <?php require_once __DIR__ . "/./../../componentes/users/footer.php"; // rodapé ?> 
    </div> 
    
</body>
</html>