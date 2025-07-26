<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../includes/verificarLogin.php";
?>
<link rel="stylesheet" href="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_CSS'] ?>adm/CadastroProjetos.css">

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

      <div class="card-projeto">
        <div class="card-content">
          <div class="card-imagem">
            <img src="../../../assets/img/turmas/turma-galeria.png" alt="Imagem do Projeto" class="img-projeto">
          </div>
          <div class="card-info">
            <h3 class="projeto-titulo">Projeto 1</h3>
            <p class="projeto-descricao">Descrição do projeto vai aqui. Este é um exemplo de texto descritivo para o projeto.</p>
          </div>
        </div>
      </div>
      <div class="card-projeto">
        <div class="card-content">
          <div class="card-imagem">
            <img src="../../../assets/img/turmas/turma-galeria.png" alt="Imagem do Projeto" class="img-projeto">
          </div>
          <div class="card-info">
            <h3 class="projeto-titulo">Projeto 2</h3>
            <p class="projeto-descricao">Descrição do projeto vai aqui. Este é um exemplo de texto descritivo para o projeto.</p>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>