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

        <a class="tab-adm-turmas" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas" href="alunos.php">ALUNOS</a>
        <a class="tab-adm-turmas active" href="sobre.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="cadastroTurmas.php">DADOS GERAIS</a>
      </div>


      <<<<<<< HEAD
        <div class="btn-novos-projeto">
        <a href="imagens.php">
          <button class="componente-botao btn-imagens">NOVOS PROJETOS</button>
        </a>

        =======
        <div class="form-container-sobre">
          <div class="input-grupos">

            <div class="input-group-sobre">
              <?php inputComponent("Nome:", "Text", "Nome"); ?>
              <textarea class="textarea-field" placeholder="Sobre:"></textarea>

              <?php inputComponent("Dia P", "text", "Dia_p"); ?>
              <textarea class="textarea-field" placeholder="Sobre:"></textarea>

              <?php inputComponent("Projeto XX", "text", "Projeto_xx"); ?>
              <textarea class="textarea-field" placeholder="Sobre:"></textarea>
            </div>

            <div class="input-group-sobre">
              <?php inputComponent("Dia I", "text", " Dia_i"); ?>
              <textarea class="textarea-field" placeholder="Sobre:"></textarea>

              <?php inputComponent("Dia E", "text", "Dia_e"); ?>
              <textarea class="textarea-field" placeholder="Sobre:"></textarea>
            </div>

            <div class="link-projeto">
              <?php inputComponent("Link de Projeto:", "text", "Link_projeto"); ?>
              <div class="btn-novos-projeto">
                <a href="imagens.php">
                  <button class="componente-botao btn-imagens">NOVOS PROJETOS</button>
                </a>
              </div>
            </div>

          </div>
          >>>>>>> origin/feature/PI-111
        </div>
  </div>
  </div>
  </div>
  </main>
  </div>
</body>

</html>