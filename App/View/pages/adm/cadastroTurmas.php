<?php

$paginaAtiva = 'turmas';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../../Config/Config.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../../Service/AuthService.php";
require_once __DIR__ . "/../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../Model/PoloModel.php";
require_once __DIR__ . "/../../../Helpers/Request.php";
require_once __DIR__ . "/../../componentes/BreadCrumbs.php";

$isEditMode = false;
$turma = null;
$tituloPagina = "Cadastro de Turma";
$actionUrl = Config::getAppUrl() . "App/Controller/TurmaController.php?action=salvar";
$imagemUrl = Config::getDirImg() . 'utilitarios/avatar.png';
$turmaId = Request::getId("turma_id");


if ($turmaId) {
    $isEditMode = true;
    $turmaModel = new TurmaModel();
    $turma = $turmaModel->buscarTurmaPorId($turmaId);

    if (!$turma) {
        header('Location: ' . Config::getDirAdm() . 'turmas.php');
        exit;
    }

    $tituloPagina = "Editar Turma";
    $actionUrl = Config::getAppUrl() . "App/Controller/TurmaController.php?action=atualizar";

    if (!empty($turma['imagem_id'])) {
        $url = $turmaModel->buscarUrlDaImagem($turma['imagem_id']);
        if ($url) {
            $imagemUrl = Config::getAppUrl() . $url;
        }
    }
}

$poloModel = new PoloModel();
$polos = $poloModel->buscarTodos();

headerComponent($tituloPagina);
$currentTab = 'Dados-gerais';
?>

<body class="layout body-adm">
    <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true;
    require_once __DIR__ . "/../../componentes/nav.php";
    require_once __DIR__ . "/../../componentes/adm/tabsTurma.php";
    ?>

    <main class="layout-main main-turmas-turmas">
      <?php 
        BreadCrumbs::gerarBreadCrumbs();
        tabsTurmaComponent($currentTab, ['turma_id' => $turmaId]);
      ?>

      <div class="container-main-adm">
        <form id="form-turma" method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data"
          style="width: 100%;">

          <?php if ($isEditMode): ?>
            <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turma['turma_id']) ?>">
            <input type="hidden" name="imagem_id_atual" value="<?= htmlspecialchars($turma['imagem_id'] ?? '') ?>">
          <?php endif; ?>

          <div class="form-top">
            <div class="form-section">
              <h1 class='h1-turma'><?= $isEditMode ? 'EDITAR TURMA' : 'CADASTRO DE TURMA' ?></h1>
           
                    
                  <?php  inputComponent('text', 'nome', 'Nome da turma' ,  ($turma['nome'] ?? ''), label:"nome", required: true)?>
              
              <div class="input-container">
                     <label class="form-label" id="text_input">Descrição</label>
              <textarea name="descricao"
                ><?= htmlspecialchars($turma['descricao'] ?? '') ?></textarea>
              </div>
           

                <div class="container_dia_data">
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
                </div>
               
                <div class="input-container">
                  <label class="form-label" id="text_input">Polo</label>
                  <select name="polo_id" required>
                    <option value="">Selecione um Polo</option>
                    <?php foreach ($polos as $polo): // Loop para criar as opções do select a partir dos dados do banco. ?>
                      <option value="<?= $polo['polo_id'] ?>" <?= ($isEditMode && isset($turma) && $polo['polo_id'] == $turma['polo_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($polo['nome']) ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
            </div>

            <div class="profile-pic">
              <!-- <small>Clique na imagem para alterar</small> -->
              <label for="imagem_turma" style="cursor: pointer;">
                Clique na imagem para alterar
                <img id="preview" src="<?= htmlspecialchars($imagemUrl) ?>" alt="Upload de Imagem">
              </label>
              <input type="file" id="imagem_turma" name="imagem_turma" accept="image/*" style="display: none;">
            </div>
               <div class="form-bottom">
            <div class="form-group-buton">
              <?php
              buttonComponent('secondary', 'Voltar', false, Config::getDirAdm() . 'turmas.php');
              buttonComponent('primary', $isEditMode ? 'Atualizar' : 'Cadastrar', true);
              ?>
            </div>
          </div>
          </div>
        </form>
      </div>
    </main>

  <?php if (isset($_SESSION['erros_turma'])): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const erros = <?= json_encode($_SESSION['erros_turma']) ?>;
        let mensagemErro = "Ocorreram os seguintes erros:\n\n";
        erros.forEach(erro => {
          mensagemErro += "- " + erro + "\n";
        });
        alert(mensagemErro);
      });
    </script>
    <?php unset($_SESSION['erros_turma']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['sucesso_cadastro'])): ?>
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        alert("<?= htmlspecialchars($_SESSION['sucesso_cadastro']) ?>");
        document.getElementById('form-turma').reset();
        document.getElementById('preview').src = "<?= Config::getDirImg() . 'utilitarios/avatar.png' ?>";
      });
    </script>
    <?php unset($_SESSION['sucesso_cadastro']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['sucesso_edicao_alert'])): ?>
    <script>
      alert("<?= htmlspecialchars($_SESSION['sucesso_edicao_alert']) ?>");
    </script>
    <?php unset($_SESSION['sucesso_edicao_alert']); ?>
  <?php endif; ?>

  <script>
    const inputFile = document.getElementById('imagem_turma');
    const previewImage = document.getElementById('preview');

    inputFile.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
      }
    });
  </script>
</body>
</html>
