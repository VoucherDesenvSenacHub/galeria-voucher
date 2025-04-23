<?php 
require_once __DIR__ . "/../../componentes/head.php";
?>

  <body>
    <div class="container"> 
      <aside class="sidebar">
        <ul class="menu">
          <li><a href="#">USUARIOS</a></li>
          <li><a href="#">TURMAS</a></li>
          <li>
            <a href="#">ESTATÍSTICAS <i class="icon-lock"></i></a>
          </li>
        </ul>
      </aside>

      <header> 
        <nav>
          <div class="imgvoucher">
          <img src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/voucher-logo.png" alt="Voucher Desenvolvedor">
          </div>
          <ul>
            <li><a href="">HOME</a></li>
            <li><a href="">TURMAS</a></li>
            <li>
              <a href="" class="botao-person">
                <span class="material-symbols-outlined">person</span>
              </a>
            </li>
          </ul>
        </nav>
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
</html>