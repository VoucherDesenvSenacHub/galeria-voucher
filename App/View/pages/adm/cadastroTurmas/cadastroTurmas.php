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
        <a class="tab-adm-turmas active" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas" href="sobre.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas" href="alunos.php">ALUNOS</a>
      </div>

      <div class="container-main-adm">
        <div class="form-section">
            <h1 class='h1-turma' >CADASTRO</h1>
            <?php inputComponent("Nome:", "text", "Nome"); ?>
            <?php inputComponent("Ano da Turma:", "text", "Ano"); ?>
            <?php inputComponent("Polo:", "text", "Polo"); ?>
            <?php inputComponent("Docentes:", "text", "Docentes"); ?>
            <?php inputComponent("Alunos:", "text", "Alunos"); ?>
          </div>

          <div class="profile-pic">
            <img src="" alt="Foto usuário" />
          </div>
        </div>
        <div class="form-bottom">
            <div class="form-group-buton">
              <?php 
                buttonComponent('secondary', 'Cancelar', false);
                buttonComponent('primary', 'Cadastrar', true);
              ?>
            </div>

      </div>
    </main>
  </div>
</body>
</html>
