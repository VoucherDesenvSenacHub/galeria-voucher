<?php


require_once __DIR__ . "/../../../../Config/App.php";
require_once __DIR__ . "/../../../../Helpers/Redirect.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../../Service/AuthService.php";
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";
require_once __DIR__ . "/../../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../componentes/BreadCrumbs.php";

$turmaId = Request::getId("turma_id");

if (!$turmaId) {
    Redirect::toAdm('listaTurmas.php');
}

$paginaAtiva = 'turmas'; 
headerComponent("Voucher Desenvolvedor - Projetos");
$currentTab = 'projetos';
$projetos = [];

try {
  $turmaModel = new TurmaModel();
  $projetos = $turmaModel->buscarProjetosPorTurma($turmaId);
} catch (Exception $e) {
  $projetos = [];
  error_log("Erro ao buscar projetos: " . $e->getMessage());
  $error_message = "Erro ao carregar projetos.";
}

$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';
?>

<link rel="stylesheet" href="<?= Config::getDirCss() ?>adm/CadastroProjetos.css">
<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

<body class="layout body-adm">
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../../componentes/nav.php";
    ?>

    <main class="layout-main main-turmas-turmas">
      <?php BreadCrumbs::gerarBreadCrumbs(); ?>
      <?php tabsTurmaComponent($currentTab, ["turma_id" => $turmaId]); ?>

      <div class="primaty-button" style="margin-top: 20px;">
          <?php 
            buttonComponent('primary', 'ADICIONAR', false,  Config::getDirAdm() . 'cadastroTurmas/Projeto.php' . ($turmaId ? "?turma_id=$turmaId" : ''), ); 
          ?>
      </div>

      <?php if (isset($error_message)): ?>
          <p><?= htmlspecialchars($error_message) ?></p>
      <?php elseif (empty($projetos)): ?>
        <p>Nenhum projeto encontrado para esta turma.</p>
      <?php else: ?>
        <?php foreach ($projetos as $projeto): ?>
          <div class="card-projeto">
            <div class="card-content">
              <div class="card-imagem">
                <img src="<?= Config::getDirImg() . 'utilitarios/sem-foto.svg' ?>" alt="Imagem do <?= htmlspecialchars($projeto['NOME_PROJETO']) ?>"
                  class="img-projeto">
              </div>
              <div class="card-info">
                <h3 class="projeto-titulo"><?= htmlspecialchars($projeto['NOME_PROJETO']) ?></h3>
                <p class="projeto-descricao"><?= htmlspecialchars($projeto['DESCRICAO_PROJETO']) ?></p>
              </div>
              <div class="card-actions" style="display: flex; gap: 10px;">
                <span class="material-symbols-outlined action-icon" style="cursor: pointer;" title="Editar">edit</span>
                <span class="material-symbols-outlined action-icon" style="cursor: pointer;" title="Excluir">delete</span>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </main>
</body>
</html>