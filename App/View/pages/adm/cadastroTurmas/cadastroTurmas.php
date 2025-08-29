<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Turma");
require_once __DIR__ . "/../../../componentes/adm/auth.php";
// Inclui os Models necessários para buscar dados do banco (turmas e polos).
require_once __DIR__ . "/../../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../../Model/PoloModel.php";

// --- LÓGICA DE PREPARAÇÃO DA PÁGINA ---

// Inicializa variáveis com valores padrão para o modo "Cadastro".
$isEditMode = false; // Flag para controlar se a página está em modo de edição.
$turma = null; // Variável para armazenar os dados da turma no modo de edição.
$tituloPagina = "Cadastro de Turma"; // Título que aparecerá na aba do navegador.
// URL para onde o formulário será enviado. Padrão é a ação 'salvar' do Controller.
$actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=salvar";
// URL da imagem de placeholder padrão.
$imagemUrl = VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png';

// 2. LÓGICA DE BUSCA DE DADOS
$projetos = [];
$isEditMode = false;
$turmaId = null;

// Verifica se o usuário logado é um administrador para exibir o botão de excluir
$is_admin = isset($_SESSION['usuario']) && $_SESSION['usuario']['perfil'] === 'adm';

// Verifica se um 'id' foi passado na URL e se é um inteiro válido.
// Se sim, a página entra no "Modo Edição".
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
  $isEditMode = true;
  $turmaModel = new TurmaModel();
  // Busca no banco os dados da turma com o ID fornecido.
  $turma = $turmaModel->buscarTurmaPorId($_GET['id']);

  // Se a turma com o ID especificado não for encontrada, redireciona para a lista.
  if (!$turma) {
    header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
    exit; // Encerra o script para garantir que o redirecionamento ocorra.
  }

  // Altera as variáveis para refletir o modo de edição.
  $tituloPagina = "Editar Turma";
  $actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=atualizar";

  // Se a turma tiver uma imagem associada, busca a URL dela.
  if (!empty($turma['imagem_id'])) {
    $url = $turmaModel->buscarUrlDaImagem($turma['imagem_id']);
    if ($url) {
      // Se a URL for encontrada, atualiza a variável $imagemUrl para exibir a imagem correta.
      $imagemUrl = VARIAVEIS['APP_URL'] . $url;
    }
  }
}

// --- BUSCA DE DADOS PARA O FORMULÁRIO ---
// Cria uma instância do PoloModel para buscar todos os polos.
$poloModel = new PoloModel();
// A variável $polos será usada para preencher o campo <select> de Polos no formulário.
$polos = $poloModel->buscarTodos();

// Renderiza o componente do cabeçalho HTML, passando o título dinâmico da página.
headerComponent($tituloPagina);

// Define a aba atual
$currentTab = 'Dados-gerais';
?>

<body class="body-adm">
  <div class="container-adm">

    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true; // Variável para o componente nav.php saber que é uma página de admin.
    require_once __DIR__ . "/../../../componentes/nav.php"; // Inclui a barra de navegação superior.
    require_once __DIR__ . "/../../../componentes/adm/tabs-turma.php"; // Inclui o componente de abas das turmas
    $isAdmin = true; // Para páginas de admin
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

      <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas <?= ($currentTab == 'dados-gerais') ? 'active' : 'active' ?>" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas <?= ($currentTab == 'projetos') ? 'active' : '' ?>" href="CadastroProjetos.php">PROJETOS</a>
        <a class="tab-adm-turmas <?= ($currentTab == 'docentes') ? 'active' : '' ?>" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas <?= ($currentTab == 'alunos') ? 'active' : '' ?>" href="alunos.php">ALUNOS</a>
      </div>


      <div class="container-main-adm">
        <form id="form-turma" method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data"
          style="width: 100%;">

          <?php if ($isEditMode): // Se estiver em modo de edição, insere campos ocultos no formulário. ?>
            <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turma['turma_id']) ?>">
            <input type="hidden" name="imagem_id_atual" value="<?= htmlspecialchars($turma['imagem_id'] ?? '') ?>">
          <?php endif; ?>

          <div class="form-top">
            <div class="form-section">
              <h1 class='h1-turma'><?= $isEditMode ? 'EDITAR TURMA' : 'CADASTRO DE TURMA' ?></h1>

              <label class="form-label" id="text_input">Nome</label>
              <input type="text" name="nome" class="input-adm-turmas"
                value="<?= htmlspecialchars($turma['nome'] ?? '') ?>">

              <label class="form-label" id="text_input">Descrição</label>
              <textarea name="descricao"
                class="input-adm-turmas"><?= htmlspecialchars($turma['descricao'] ?? '') ?></textarea>
              <div class="dia">
                <div class="container_input_text">
                  <label class="form-label" id="text_inicio">Início</label>
                  <input type="date" name="data_inicio" class="inicio"
                    value="<?= htmlspecialchars($turma['data_inicio'] ?? '') ?>">
                </div>
                <div class="container_input_text">
                  <label class="form-label" id="text_termino">Término</label>
                  <input type="date" name="data_fim" class="termino"
                    value="<?= htmlspecialchars($turma['data_fim'] ?? '') ?>">
                </div>
                <div class="container_text_polo">
                  <label class="form-label" id="text_input">Polo</label>
                  <select name="polo_id" class="input-adm-turmas">
                    <option value="">Selecione um Pólo</option>
                    <?php foreach ($polos as $polo): // Loop para criar as opções do select a partir dos dados do banco. ?>
                      <option value="<?= $polo['polo_id'] ?>" <?= ($isEditMode && isset($turma) && $polo['polo_id'] == $turma['polo_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($polo['nome']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
            </div>

            <div class="profile-pic">
              <small>Clique na imagem para alterar</small>
              <label for="imagem_turma" style="cursor: pointer;">
                <img id="preview" src="<?= htmlspecialchars($imagemUrl) ?>" alt="Upload de Imagem">
              </label>
              <input type="file" id="imagem_turma" name="imagem_turma" accept="image/*" style="display: none;">
            </div>
          </div>
          <div class="form-bottom">
        <div class="form-top">
          <div class="form-section">
            <h1 class='h1-turma'>CADASTRO</h1>
            <?php inputComponent("Nome:", "text", "Nome"); ?>
            <?php inputComponent("Ano da Turma:", "text", "Ano"); ?>
            <?php inputComponent("Polo:", "text", "Polo"); ?>
            <?php inputComponent("Docentes:", "text", "Docentes"); ?>
            <?php inputComponent("Alunos:", "text", "Alunos"); ?>
          </div>
          <div class="profile-pic">
            <img id="preview" src="http://localhost/galeria-voucher/App/View/assets/img/utilitarios/avatar.png" alt="Upload">
          </div>
        </div>
        <div class="form-bottom">
            <div class="form-group-buton">
              <?php
              // Componentes de botão reutilizáveis.
              // O botão "Voltar" redireciona para a lista de turmas.
              buttonComponent('secondary', 'Voltar', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
              // O texto do botão primário muda de 'Atualizar' para 'Cadastrar' dependendo do modo.
              buttonComponent('primary', $isEditMode ? 'Atualizar' : 'Cadastrar', true);
              buttonComponent('secondary', 'Cancelar', false);
              buttonComponent('primary', 'Cadastrar', true);
              ?>
            </div>

          </div>
        </div>




      </div>
    </main>
  </div>
</body>

</html>