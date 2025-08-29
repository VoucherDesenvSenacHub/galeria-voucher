<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Projetos");
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php";
require_once __DIR__ . "/../../../../Model/TurmaModel.php";

// Define a aba atual
$currentTab = 'Projetos';

// 2. LÓGICA DE BUSCA DE DADOS
$projetos = [];
$isEditMode = false;
$turmaId = null;

try {
  $turmaModel = new TurmaModel();

  // Verifica se o ID da turma foi passado (modo edição)
  if (isset($_GET['id']) && !empty($_GET['id'])) {
    $turmaId = (int) $_GET['id'];

    if ($turmaId > 0) {
      $isEditMode = true;
      $projetos = $turmaModel->BuscarProjetosPorTurma($turmaId);
    }
  }
  // Se não houver ID, está no modo cadastro (não é erro)

} catch (Exception $e) {
  // Em caso de erro, define $projetos como um array vazio e loga o erro
  $projetos = [];
  error_log("Erro ao buscar projetos: " . $e->getMessage());

  // Exibe mensagem de erro para o usuário apenas se estiver no modo edição
  if ($isEditMode) {
    $error_message = "Erro ao carregar projetos: " . $e->getMessage();
  }
}

// Verifica se o usuário logado é um administrador para exibir o botão de excluir
$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';
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
      <?php
      // Usa o componente de abas das turmas
      $turmaId = isset($_GET['id']) ? (int) $_GET['id'] : null;
      tabsTurmaComponent($currentTab, $turmaId);
      ?>
      <div class="page-title-container">
        <h1 class="page-title">
          <?= 'Turmas > ' . $currentTab ?>
        </h1>
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
                <img src="<?= $projeto['URL_IMAGEM'] ?>" alt="Imagem do <?= htmlspecialchars($projeto['NOME_PROJETO']) ?>"
                  class="img-projeto">
              </div>
              <div class="card-info">
                <h3 class="projeto-titulo"><?= htmlspecialchars($projeto['NOME_PROJETO']) ?></h3>
                <p class="projeto-descricao"><?= htmlspecialchars($projeto['DESCRICAO_PROJETO']) ?></p>
              </div>
              <div style="display: flex; align-items: center; margin-left: auto;">
                <span class="material-symbols-outlined" style="cursor: pointer; margin-right: 10px;"
                  title="Editar">edit</span>
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