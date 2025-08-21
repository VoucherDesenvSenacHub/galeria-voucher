<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Projetos");
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/TurmaModel.php";


    try {
      $projetos = [];

      if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $turmaId = (int) $_GET['id'];
        $turmaModel = new TurmaModel();
        $projetos = $turmaModel->BuscarProjetosPorTurma($turmaId);
      }
    } catch (Exception $e) {
      $projetos = [];
      error_log("Erro ao buscar projetos: " . $e->getMessage());
}




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

      <?php if (empty($projetos)): ?>
    <p>Nenhum projeto encontrado para esta turma.</p>
<?php else: ?>
    <?php foreach ($projetos as $projeto): ?>
        <div class="card-projeto">
            <div class="card-content" style="display: flex; align-items: center; justify-content: space-between;">
                <div class="card-imagem">
                    <img src="<?= $projeto['URL_IMAGEM'] ?>" alt="Imagem do <?= htmlspecialchars($projeto['NOME_PROJETO']) ?>" class="img-projeto">
                </div>
                <div class="card-info">
                    <h3 class="projeto-titulo"><?= htmlspecialchars($projeto['NOME_PROJETO']) ?></h3>
                    <p class="projeto-descricao"><?= htmlspecialchars($projeto['DESCRICAO_PROJETO']) ?></p>
                </div>
                <div style="display: flex; align-items: center; margin-left: auto;">
                    <span class="material-symbols-outlined" style="cursor: pointer; margin-right: 10px;" title="Editar">edit</span>
                    <span class="material-symbols-outlined" style="cursor: pointer;" title="Excluir">delete</span>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

    </main>
  </div>
</body>

</html>