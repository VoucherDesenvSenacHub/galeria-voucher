<?php 
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
?>

<body class="body-adm">
  <div class="container-adm">
    
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php require_once __DIR__ . "/../../../componentes/adm/nav.php"; ?>

    <?php
      $imagens = [
        ["titulo" => "IMAGEM DA TURMA", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA I", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA P", "quantidade" => 6],
        ["titulo" => "IMAGEM DO DIA E", "quantidade" => 6],
      ];
    ?>

    <main class="main-turmas-turmas">
      <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas active" href="sobre.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas" href="alunos.php">ALUNOS</a>
      </div>

      <h1 class="h1-sobre">CADASTRO</h1>

      <div class="form-container-sobre">
        <div class="input-grupos">
          
          <div class="input-group-sobre">
            <?php inputComponent("Nome:", "text", "nome"); ?>
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>

            <?php inputComponent("Dia P", "text", "dia_p"); ?>
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>

            <?php inputComponent("Projeto XX", "text", "projeto_xx"); ?>
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>
          </div>

          <div class="input-group-sobre">
            <?php inputComponent("Dia I", "text", "dia_i"); ?>
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>

            <?php inputComponent("Dia E", "text", "dia_e"); ?>
            <textarea class="textarea-field" placeholder="Sobre:"></textarea>
          </div>

          <div class="link-projeto">
            <?php inputComponent("Link de Projeto:", "text", "link_projeto"); ?>
            <div class="btn-novos-projeto">
              <a href="imagens.php">
                <button class="componente-botao btn-imagens">NOVOS PROJETOS</button>
              </a>
            </div>
          </div>

        </div>
      </div>
    </main>
  </div>
</body>
</html>
