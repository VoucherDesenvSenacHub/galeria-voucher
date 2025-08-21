<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Projetos");
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";

// Define a aba atual
$currentTab = 'projetos';
?>
<link rel="stylesheet" href="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_CSS'] ?>adm/CadastroProjetos.css">

<!-- Ícones Google -->
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<body class="body-adm">
  <div class="container-adm">
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
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
      <?php 
      // Usa o componente de abas das turmas
      $turmaId = isset($_GET['id']) ? (int)$_GET['id'] : null;
      tabsTurmaComponent($currentTab, $turmaId);
      ?>

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
          <div class="card-actions">
            <span class="material-symbols-outlined action-icon" title="Editar">edit</span>
            <span class="material-symbols-outlined action-icon" title="Excluir">delete</span>
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
          <div class="card-actions">
            <span class="material-symbols-outlined action-icon" title="Editar">edit</span>
            <span class="material-symbols-outlined action-icon" title="Excluir">delete</span>
          </div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
