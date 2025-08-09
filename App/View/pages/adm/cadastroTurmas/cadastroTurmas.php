<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../../Model/PoloModel.php";

$modoEdicao = false;
$turma = null;
$tituloPagina = "Cadastro de Turma";
$actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=salvar";
$imagemUrl = VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png';

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $modoEdicao = true;
    $turmaModel = new TurmaModel();
    $turma = $turmaModel->buscarPorId($_GET['id']);
    
    if (!$turma) {
        header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
        exit;
    }

    $tituloPagina = "Editar Turma";
    $actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=atualizar";

    if (!empty($turma['imagem_id'])) {
        $url = $turmaModel->buscarUrlDaImagem($turma['imagem_id']);
        if ($url) {
            $imagemUrl = VARIAVEIS['APP_URL'] . $url;
        }
    }
}

$poloModel = new PoloModel();
$polos = $poloModel->buscarTodos();

headerComponent($tituloPagina);
?>

<body class="body-adm">
  <div class="container-adm">
    <?php require_once __DIR__ . "/../../../componentes/adm/sidebar.php"; ?>
    <?php
    $isAdmin = true; 
    require_once __DIR__ . "/../../../componentes/nav.php";
    ?>

    <main class="main-turmas-turmas">
    <div class="tabs-adm-turmas">
        <a class="tab-adm-turmas active" href="cadastroTurmas.php">DADOS GERAIS</a>
        <a class="tab-adm-turmas" href="CadastroProjetos.php">PROJETOS</a>
        <a class="tab-adm-turmas" href="docentes.php">DOCENTES</a>
        <a class="tab-adm-turmas" href="alunos.php">ALUNOS</a>
      </div>

      <div class="container-main-adm">
        <form id="form-turma" method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data" style="width: 100%;">
            
            <?php if ($modoEdicao): ?>
                <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turma['turma_id']) ?>">
                <input type="hidden" name="imagem_id_atual" value="<?= htmlspecialchars($turma['imagem_id'] ?? '') ?>">
            <?php endif; ?>

            <div class="form-top">
              <div class="form-section">
                <h1 class='h1-turma'><?= $modoEdicao ? 'EDITAR TURMA' : 'CADASTRO DE TURMA' ?></h1>
                
                <label class="form-label" >Nome</label>
                <input type="text" name="nome" class="input-adm-turmas" value="<?= htmlspecialchars($turma['nome'] ?? '') ?>">

                <label class="form-label" >Descrição</label>
                <textarea name="descricao" class="input-adm-turmas" ><?= htmlspecialchars($turma['descricao'] ?? '') ?></textarea>

                <label class="form-label" >Início</label>
                <input type="date" name="data_inicio" class="input-adm-turmas" value="<?= htmlspecialchars($turma['data_inicio'] ?? '') ?>">

                <label class="form-label" >Término</label>
                <input type="date" name="data_fim" class="input-adm-turmas" value="<?= htmlspecialchars($turma['data_fim'] ?? '') ?>">

                <label class="form-label" >Pólo</label>
                <select name="polo_id" class="input-adm-turmas">
                    <option value="">Selecione um Pólo</option>
                    <?php foreach ($polos as $polo): ?>
                        <option value="<?= $polo['polo_id'] ?>" <?= ($modoEdicao && isset($turma) && $polo['polo_id'] == $turma['polo_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($polo['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
                  buttonComponent('secondary', 'Voltar', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                  buttonComponent('primary', $modoEdicao ? 'Atualizar' : 'Cadastrar', true);
                  ?>
                </div>
              </div>
        </form>
      </div>
    </main>
  </div>

  <?php if (isset($_SESSION['erros_turma'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
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
        document.addEventListener('DOMContentLoaded', function() {
            // Exibe o alerta com a mensagem de sucesso
            alert("<?= htmlspecialchars($_SESSION['sucesso_cadastro']) ?>");
            // Limpa os campos do formulário para um novo cadastro
            document.getElementById('form-turma').reset();
            // Reseta a imagem de preview para a padrão
            document.getElementById('preview').src = "<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png' ?>";
        });
    </script>
    <?php unset($_SESSION['sucesso_cadastro']); // Limpa a sessão para não mostrar o alerta novamente ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['sucesso_edicao_alert'])): ?>
    <script>
        alert("<?= htmlspecialchars($_SESSION['sucesso_edicao_alert']) ?>");
    </script>
    <?php unset($_SESSION['sucesso_edicao_alert']); ?>
  <?php endif; ?>

  
  <script>
    // Script de preview da imagem (sem alterações)
    const inputFile = document.getElementById('imagem_turma');
    const previewImage = document.getElementById('preview');
    inputFile.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) { previewImage.src = e.target.result; }
            reader.readAsDataURL(file);
        }
    });
  </script>
</body>
</html>