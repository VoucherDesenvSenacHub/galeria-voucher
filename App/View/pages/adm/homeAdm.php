<?php
require_once __DIR__ . "/../../../Config/App.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../../Service/AuthService.php";
require_once __DIR__ . "/../../componentes/breadCrumbs.php";

headerComponent('Página inicial - ADM');

$paginaAtiva = 'home';
?>
<link rel="stylesheet" href="<?= Config::getDirCss() ?>adm/home-adm.css">
<link rel="stylesheet" href="<?= Config::getDirCss() ?>adm/nav.css">

<body class="layout body-adm">
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../componentes/nav.php";
    require_once __DIR__ . "/../../componentes/adm/sidebar.php"; 
    ?>

    <main class="content-adm layout-main">
      <div class="user-profile-adm">
        <div>
          <img class="img-Adm" src="<?= $usuarioImagem ?>" alt="Foto de <?= $usuarioNome ?>">
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