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
        <a class="tab-adm-turmas" href="cadastroTurmas.php">TURMA</a>
        <a class="tab-adm-turmas active" href="sobre.php">SOBRE</a>
        <a class="tab-adm-turmas" href="imagens.php">IMAGENS</a>
      </div>

      <h1 class="h1-sobre">CADASTRO</h1>

      <div class="form-container-sobre">
        <div class="input-grupos">
          <div class="input-group-sobre">
            <input type="text" class="input-field" placeholder="Nome:">
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>
            <input type="text" class="input-field" placeholder="Dia P">
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>
            <input type="text" class="input-field" placeholder="Projeto XX">
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>
          </div>

          <div class="input-group-sobre-big">
            <input type="text" class="input-field" placeholder="Dia I">
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>
            <input type="text" class="input-field" placeholder="Dia E">
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>
          </div>

          <div class="link-projeto">
            <input type="text" class="input-projeto" placeholder="Link de Projeto:">
            <div class="btn-novos-projeto">
              <button class="componente-botao btn-imagens">NOVOS PROJETOS</button>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
