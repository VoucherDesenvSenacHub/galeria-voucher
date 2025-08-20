<?php
// Garante que uma sessão PHP esteja ativa. Se não estiver, inicia uma.
// Isso é necessário para usar as variáveis de sessão ($_SESSION) para exibir mensagens de erro/sucesso.
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// --- INCLUSÃO DE DEPENDÊNCIAS ---
// Carrega variáveis de configuração globais (como URLs base).
require_once __DIR__ . "/../../../../Config/env.php";
// Inclui o cabeçalho HTML (<head>, CSS, etc.).
require_once __DIR__ . "/../../../componentes/head.php";
// Inclui um script que verifica se o usuário administrativo está logado (autenticação).
require_once __DIR__ . "/../../../componentes/adm/auth.php";
// Inclui os Models necessários para buscar dados do banco (turmas e polos).
require_once __DIR__ . "/../../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../../Model/PoloModel.php";

// --- LÓGICA DE PREPARAÇÃO DA PÁGINA ---

// Inicializa variáveis com valores padrão para o modo "Cadastro".
$modoEdicao = false; // Flag para controlar se a página está em modo de edição.
$turma = null; // Variável para armazenar os dados da turma no modo de edição.
$tituloPagina = "Cadastro de Turma"; // Título que aparecerá na aba do navegador.
// URL para onde o formulário será enviado. Padrão é a ação 'salvar' do Controller.
$actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=salvar";
// URL da imagem de placeholder padrão.
$imagemUrl = VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png';

// Verifica se um 'id' foi passado na URL e se é um inteiro válido.
// Se sim, a página entra no "Modo Edição".
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
  $modoEdicao = true;
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
?>

<body class="body-adm">
  <div class="container-adm">
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; // Inclui a barra lateral de navegação ?>
    <?php
    $isAdmin = true; // Variável para o componente nav.php saber que é uma página de admin.
    require_once __DIR__ . "/../../../componentes/nav.php"; // Inclui a barra de navegação superior.
    ?>

    <main class="main-turmas-turmas">
      <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas active" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas" href="CadastroProjetos.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas" href="alunos.php">ALUNOS</a>
      </div>

      <div class="container-main-adm">
        <form id="form-turma" method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data"
          style="width: 100%;">

          <?php if ($modoEdicao): // Se estiver em modo de edição, insere campos ocultos no formulário. ?>
            <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turma['turma_id']) ?>">
            <input type="hidden" name="imagem_id_atual" value="<?= htmlspecialchars($turma['imagem_id'] ?? '') ?>">
          <?php endif; ?>

          <div class="form-top">
            <div class="form-section">
              <h1 class='h1-turma'><?= $modoEdicao ? 'EDITAR TURMA' : 'CADASTRO DE TURMA' ?></h1>

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
                      <option value="<?= $polo['polo_id'] ?>" <?= ($modoEdicao && isset($turma) && $polo['polo_id'] == $turma['polo_id']) ? 'selected' : '' ?>>
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
            <div class="form-group-buton">
              <?php
              // Componentes de botão reutilizáveis.
              // O botão "Voltar" redireciona para a lista de turmas.
              buttonComponent('secondary', 'Voltar', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
              // O texto do botão primário muda de 'Atualizar' para 'Cadastrar' dependendo do modo.
              buttonComponent('primary', $modoEdicao ? 'Atualizar' : 'Cadastrar', true);
              ?>
            </div>
          </div>
        </form>
      </div>
    </main>
  </div>

  <?php // --- SCRIPTS PARA FEEDBACK DO USUÁRIO (MENSAGENS FLASH) --- ?>

  <?php if (isset($_SESSION['erros_turma'])): // Se houver erros de validação na sessão... ?>
    <script>
      // Este script será executado assim que a página carregar.
      document.addEventListener('DOMContentLoaded', function () {
        // Decodifica os erros (que foram passados como JSON pelo Controller) para um array JavaScript.
        const erros = <?= json_encode($_SESSION['erros_turma']) ?>;
        let mensagemErro = "Ocorreram os seguintes erros:\n\n";
        // Monta uma string com todos os erros.
        erros.forEach(erro => {
          mensagemErro += "- " + erro + "\n";
        });
        // Exibe um alerta para o usuário.
        alert(mensagemErro);
      });
    </script>
    <?php unset($_SESSION['erros_turma']); // Limpa a variável de sessão para que o erro não seja exibido novamente. ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['sucesso_cadastro'])): // Se houver uma mensagem de sucesso de CADASTRO... ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        // Exibe o alerta com a mensagem de sucesso.
        alert("<?= htmlspecialchars($_SESSION['sucesso_cadastro']) ?>");
        // Limpa todos os campos do formulário para permitir um novo cadastro facilmente.
        document.getElementById('form-turma').reset();
        // Restaura a imagem de preview para a imagem padrão.
        document.getElementById('preview').src = "<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png' ?>";
      });
    </script>
    <?php unset($_SESSION['sucesso_cadastro']); // Limpa a sessão. ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['sucesso_edicao_alert'])): // Se houver uma mensagem de sucesso de EDIÇÃO... ?>
    <script>
      alert("<?= htmlspecialchars($_SESSION['sucesso_edicao_alert']) ?>");
    </script>
    <?php unset($_SESSION['sucesso_edicao_alert']); // Limpa a sessão. ?>
  <?php endif; ?>


  <script>
    // --- SCRIPT PARA PREVIEW DA IMAGEM ---
    const inputFile = document.getElementById('imagem_turma');
    const previewImage = document.getElementById('preview');

    // Adiciona um 'escutador' de eventos ao input de arquivo.
    inputFile.addEventListener('change', function () {
      // Pega o primeiro arquivo selecionado pelo usuário.
      const file = this.files[0];
      if (file) {
        // Usa a API FileReader para ler o arquivo de imagem localmente.
        const reader = new FileReader();
        // Quando a leitura estiver completa...
        reader.onload = function (e) {
          // ...define o atributo 'src' da tag <img> para o resultado da leitura, exibindo o preview.
          previewImage.src = e.target.result;
        }
        // Inicia a leitura do arquivo como uma Data URL.
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>

</html>