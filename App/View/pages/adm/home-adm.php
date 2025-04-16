<?php 
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>

<body>
    <div class="container"> 
      <aside class="sidebar">
        <?php require_once __DIR__ . "/./../../componentes/adm/sidebar.php"; ?>
      </aside>

      <header> 
        <?php require_once __DIR__ . "/./../../componentes/adm/nav.php"; ?>
      </header>

      <main class="content">
        <div class="user-profile">
          <div class="user-icon"></div>
          <div class="user-name">NOME DO USUÁRIO</div>
        </div>
        <div class="welcome-message">BEM VINDO</div>
      </main>
    </div> 
</body>