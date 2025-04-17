<?php 
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>

  <body class="body-adm">
    <div class="container-adm"> 

      <aside class="sidebar-adm">
            <?php require_once __DIR__ . "/./../../componentes/adm/sidebar.php"; ?>
      </aside>

      <header> 
        <nav>
          <?php require_once __DIR__ . "/./../../componentes/adm/nav.php"; ?>
        </nav>
      </header>

      <main class="content-adm">
          <div class="user-profile-adm">
              <div class="user-icon-adm"></div>

              <div class="user-name-adm">
                  NOME DO USUÁRIO
              </div>
          </div>
          
          <div class="welcome-message-adm">
              BEM VINDO
          </div>
      </main>
    </div> 
  </body>
</html>