<?php 
require_once __DIR__ . "/../../../Config/env.php";
require_once __DIR__ . "/../../componentes/head.php";
?>

  <body class="body-adm">
    <div class="container-adm">
       
        <?php require_once __DIR__ . "/./../../componentes/adm/sidebar.php"; ?>
        <?php require_once __DIR__ . "/./../../componentes/adm/nav.php"; ?>

      <!-- <main class="content-adm">
          <div class="user-profile-adm">
              <div class="user-icon-adm"></div>

              <div class="user-name-adm">
                  NOME DO USUÁRIO
              </div>
          </div>
          
          <div class="welcome-message-adm">
              BEM VINDO
          </div>
      </main> -->


      <main class="main-turmas-turmas">
            <div class="tabs">
              <button class="tab active">TURMA</button>
              <button class="tab">SOBRE</button>
              <button class="tab">IMAGENS</button>
            </div>

            <div class="container">
              <div class="form-section">
                <h1>CADASTRO</h1>
                <input type="text" placeholder="Nome:" />
                <input type="text" placeholder="Ano da Turma:" />
                <input type="text" placeholder="Polo:" />
                <input type="text" placeholder="Docentes:" />
                <input type="text" placeholder="Alunos:" />
              </div>

              <div class="profile-pic">
                <img src="" alt="Ícone de usuário" />
              </div>
            </div>
          </main> 
    </div> 
  </body>
</html>