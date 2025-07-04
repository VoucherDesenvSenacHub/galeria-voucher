<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

<body class="body-cadastro-turmas">
  <div class="container-adm">

    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php 
        $isAdmin = true; // Para páginas de admin
        require_once __DIR__ . "/../../../componentes/nav.php"; 
    ?>

    <?php
      $imagens = [
          ["titulo" => "IMAGEM DA TURMA", "quantidade" => 6],
          ["titulo" => "IMAGEM DO DIA I", "quantidade" => 6],
          ["titulo" => "IMAGEM DO DIA P", "quantidade" => 6],
          ["titulo" => "IMAGEM DO DIA E", "quantidade" => 6],
      ];
    ?>

    <main class="main-turmas-imagens">

      <div class="container-imagens">
        <?php foreach ($imagens as $imagem): ?>
          <div class="section-imagens">
            <h2><?= $imagem['titulo'] ?> <span><?= $imagem['quantidade'] ?>/<?= $imagem['quantidade'] ?></span></h2>
            <div class="images-row-imagens">
              <?php for ($i = 0; $i < $imagem['quantidade']; $i++): ?>
                <img class="img-imagens" src="placeholder.png" alt="Imagem">
              <?php endfor; ?>
            </div>
          </div>
        <?php endforeach; ?>

      </div>
      <div class="buttons-imagem">
        <button class="componente-botao cancel-imagens">CANCELAR</button>
        <button class="componente-botao submit-imagens">CADASTRAR</button>
      </div>
    </main>
  </div>
</body>
</html>
