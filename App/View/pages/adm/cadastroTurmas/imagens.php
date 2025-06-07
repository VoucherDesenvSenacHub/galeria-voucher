<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

  <body class="body-adm">
    <div class="container-adm">
       
        <?php require_once __DIR__ . "/./../../../componentes/adm/sidebar.php"; ?>
        <?php require_once __DIR__ . "/./../../../componentes/adm/nav.php"; ?>

        <?php
    $imagens = [
        ["titulo" => "IMAGEM DA TURMA", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA I", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA P", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA E", "quantidade" => 6],
    ];
    ?>

    <main class="main-turmas-turmas">
        <div class="tabs-adm-turmas">
            <button class="tab-adm-turmas ">TURMA</button>
            <button class="tab-adm-turmas ">SOBRE</button>
            <button class="tab-adm-turmas active ">IMAGENS</button>
        </div>

        <div class="container-imagens">
            <?php foreach ($imagens as $imagem): ?>
                <div class="section-imagens">
                    <h2><?= $imagem['titulo'] ?> <span><?= $imagem['quantidade'] ?>/<?= $imagem['quantidade'] ?></span></h2>
                    <div class="images-row-imagens">
                        <?php for ($i = 0; $i < $imagem['quantidade']; $i++): ?>
                            <img class="img-imagens" src="placeholder.png" alt="Imagem" class="image-placeholder">
                        <?php endfor; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="buttons-imagens">
                <button class="cancel-imagens">CANCELAR</button>
                <button class="submit-imagens">CADASTRAR</button>
            </div>
        </div>
    </main>
  </body>
</html>