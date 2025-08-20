<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Projetos");
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/TurmaModel.php";
?>

<link rel="stylesheet" href="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_CSS'] ?>adm/CadastroProjetos.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<body class="body-adm">
  <div class="container-adm">
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../../componentes/nav.php";
    ?>

    <main class="main-turmas-turmas">
      <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas active" href="CadastroProjetos.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas" href="alunos.php">ALUNOS</a>
      </div>

      <div class="primaty-button">
        <a href="imagens.php">
          <?php buttonComponent('primary', 'ADICIONAR', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'cadastroTurmas/Projeto.php'); ?>
        </a>
      </div>

      <?php
      try {
        $turmaModel = new TurmaModel();
        $projetos = $turmaModel->BuscarTurmascomDescricao(); // Deve retornar ['titulo','descricao','imagem_url']
        if (!is_array($projetos)) $projetos = [];
      } catch (Exception $e) {
        $projetos = [];
        error_log("Erro ao buscar projetos: " . $e->getMessage());
      }
      ?>

      <?php foreach ($projetos as $projeto): ?>
        <div class="card-projeto">
          <div class="card-content" style="display: flex; align-items: center; justify-content: space-between;">
            <div class="card-imagem">
              <img src="<?= VARIAVEIS['APP_URL'] . $projeto['URL_IMAGEM'] ?>"
                alt="Imagem da <?= htmlspecialchars($projeto['NOME_TURMA']) ?>"
                class="img-projeto">
            </div>
            <div class="card-info">
              <h3 class="projeto-titulo"><?= htmlspecialchars($projeto['NOME_TURMA']) ?></h3>
              <p class="projeto-descricao"><?= htmlspecialchars($projeto['DESCRICAO_TURMA']) ?></p>
              <small class="projeto-polo"><?= htmlspecialchars($projeto['NOME_POLO']) ?></small>
            </div>
            <div style="display: flex; align-items: center; margin-left: auto;">
              <span class="material-symbols-outlined" style="cursor: pointer; margin-right: 10px;" title="Editar">edit</span>
              <span class="material-symbols-outlined" style="cursor: pointer;" title="Excluir">delete</span>
            </div>
          </div>
        </div>
      <?php endforeach; ?>

    </main>
  </div>
</body>

</html>