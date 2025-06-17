<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

<body class="body-adm">
  <div class="container-adm">
    
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php require_once __DIR__ . "/../../../componentes/adm/nav.php"; ?>

    <main class="main-turmas-turmas">
      <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas active" href="cadastroTurmas.php">TURMA</a>
        <a class="tab-adm-turmas" href="sobre.php">SOBRE</a>
        <a class="tab-adm-turmas" href="imagens.php">IMAGENS</a>
      </div>

      <div class="container-main-adm">
        <div class="form-section">
          <h1>CADASTRO</h1>
          <input class="input-adm-turmas" type="text" placeholder="Nome:" />
          <input class="input-adm-turmas" type="text" placeholder="Ano da Turma:" />
          <input class="input-adm-turmas" type="text" placeholder="Polo:" />
          <input class="input-adm-turmas" type="text" placeholder="Docentes:" />
          <input class="input-adm-turmas" type="text" placeholder="Alunos:" />
        </div>

        <div class="profile-pic">
          <img src="" alt="Foto usuário" />
        </div>
      </div>
    </main>
  </div>
</body>
</html>
