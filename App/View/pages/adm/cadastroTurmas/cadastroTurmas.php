<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

<body class="body-adm">
  <div class="container-adm">
    
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php 
      $isAdmin = true; // Para páginas de admin
      require_once __DIR__ . "/../../../componentes/nav.php"; 
    ?>

    <main class="main-turmas-turmas">
      <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas active" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas" href="sobre.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas" href="alunos.php">ALUNOS</a>
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
