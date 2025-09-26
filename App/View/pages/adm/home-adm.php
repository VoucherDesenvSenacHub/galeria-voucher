<?php
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../../Service/AuthService.php";
require_once __DIR__ . "/../../componentes/BreadCrumbs.php";

headerComponent('Página inicial - ADM');

$paginaAtiva = 'home'; // Variável para identificar a página ativa

?>
<link rel="stylesheet" href="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_CSS"] ?>adm/home-adm.css">
<link rel="stylesheet" href="<?= VARIAVEIS["APP_URL"] . VARIAVEIS["DIR_CSS"] ?>adm/nav.css">

<body class="layout body-adm">

    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true; // Para páginas de admin
    $useHeader = true;
    require_once __DIR__ . "/../../componentes/nav.php";
    ?>

    <main class="content-adm layout-main">
      <div class="user-profile-adm">
        <div>
          <img class="img-Adm" src="<?= $usuarioImagem ?>"
            alt="Foto de <?= $usuarioNome ?>"
          >
        </div>

        <div class="welcome-message-adm">
          BEM VINDO
        </div>

        <div class="user-name-adm">
          <?= $usuarioNome ?>
        </div>
      </div>

    </main>
</body>

</html>