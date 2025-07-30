<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Turma");
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
        <a class="tab-adm-turmas <?= ($currentTab == 'dados-gerais') ? 'active' : 'active' ?>" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas <?= ($currentTab == 'projetos') ? 'active' : '' ?>" href="CadastroProjetos.php">PROJETOS</a>
        <a class="tab-adm-turmas <?= ($currentTab == 'docentes') ? 'active' : '' ?>" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas <?= ($currentTab == 'alunos') ? 'active' : '' ?>" href="alunos.php">ALUNOS</a>
      </div>

      <div class="container-main-adm">
        <div class="form-top">
          <div class="form-section">
            <h1 class='h1-turma'>CADASTRO</h1>
            <?php inputComponent("Nome:", "text", "Nome"); ?>
            <?php inputComponent("Ano da Turma:", "text", "Ano"); ?>
            <?php inputComponent("Polo:", "text", "Polo"); ?>
            <?php inputComponent("Docentes:", "text", "Docentes"); ?>
            <?php inputComponent("Alunos:", "text", "Alunos"); ?>
          </div>
          <div class="profile-pic">
            <img id="preview" src="http://localhost/galeria-voucher/App/View/assets/img/utilitarios/avatar.png" alt="Upload">
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
        </div>




      </div>
    </main>
  </div>
</body>

</html>