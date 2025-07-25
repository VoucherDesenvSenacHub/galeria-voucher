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
        <a class="tab-adm-turmas active" href="CadastroProjetos.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="cadastroTurmas.php">DADOS GERAIS</a>
      </div>



      <div class="primaty-button">
        <a href="imagens.php">
          <?php buttonComponent('primary', 'ADICIONAR', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/Projeto.php'); ?>
        </a>
      </div>

      <div class="PrimeiroProjeto">
            <div class="nome-e-descricao">
              <input type="text" class="input-field" placeholder="Nome do Projeto:">
              <textarea class="textarea-field" placeholder="Descrição:"></textarea>
            </div>
              <img src="../../../../../referencia/area-adm/tela-inicial-adm/assets/projetoimg.png"alt="Foto Turma" class="foto-projeto" />
      </div>

  </div>
  </div>
  </div>
  </div>
  </main>
  </div>
</body>

</html>