<?php
// --- Bloco de Depuração Temporário ---
// Força a exibição de todos os erros do PHP.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// --- Fim do Bloco de Depuração ---

require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/TurmaModel.php";
require_once __DIR__ . "/../../../../Model/PoloModel.php";

// --- LÓGICA PARA MODO EDIÇÃO VS CRIAÇÃO ---
$modoEdicao = false;
$turma = null;
$tituloPagina = "Cadastro de Turma";
$actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=salvar";

if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $modoEdicao = true;
    $turmaModel = new TurmaModel();
    $turma = $turmaModel->buscarPorId($_GET['id']);
    
    if (!$turma) {
        $_SESSION['erros_turma'] = ["Turma não encontrada."];
        header('Location: ' . VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
        exit;
    }

    $tituloPagina = "Editar Turma";
    $actionUrl = VARIAVEIS['APP_URL'] . "App/Controls/TurmaController.php?action=atualizar";
}

// Busca os polos para o dropdown
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
        
        <?php if (isset($_SESSION['erros_turma'])): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin: 20px auto; width: 80%;">
                <strong>Ocorreram os seguintes erros:</strong>
                <ul>
                    <?php foreach ($_SESSION['erros_turma'] as $erro): ?>
                        <li><?= htmlspecialchars($erro) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['erros_turma']); ?>
        <?php endif; ?>

        <form id="form-turma" method="POST" action="<?= $actionUrl ?>" enctype="multipart/form-data" style="width: 100%;">
            
            <?php if ($modoEdicao): ?>
                <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turma['turma_id']) ?>">
                <input type="hidden" name="imagem_id_atual" value="<?= htmlspecialchars($turma['imagem_id'] ?? '') ?>">
            <?php endif; ?>

            <div class="form-top">
              <div class="form-section">
                <h1 class='h1-turma'><?= $modoEdicao ? 'EDITAR TURMA' : 'CADASTRO DE TURMA' ?></h1>
                
                <label class="form-label" >Nome</label>
                <input type="text" name="nome" class="input-adm-turmas" value="<?= htmlspecialchars($turma['nome'] ?? '') ?>" required>

                <label class="form-label" >Descrição</label>
                <textarea name="descricao" class="input-adm-turmas" ><?= htmlspecialchars($turma['descricao'] ?? '') ?></textarea>

                <label class="form-label" >Início</label>
                <input type="date" name="data_inicio" class="input-adm-turmas" value="<?= htmlspecialchars($turma['data_inicio'] ?? '') ?>" required>

                <label class="form-label" >Término</label>
                <input type="date" name="data_fim" class="input-adm-turmas" value="<?= htmlspecialchars($turma['data_fim'] ?? '') ?>">

                <label class="form-label" >Pólo</label>
                <select name="polo_id" class="input-adm-turmas" required>
                    <option value="">Selecione um Pólo</option>
                    <?php foreach ($polos as $polo): ?>
                        <option value="<?= $polo['polo_id'] ?>" <?= ($modoEdicao && isset($turma) && $polo['polo_id'] == $turma['polo_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($polo['nome']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
              </div>

              <div class="profile-pic" style="display: flex; flex-direction: column; align-items: center;">
                <small style="text-align: center; display: block; margin-bottom: 5px;">Clique na imagem para alterar</small>
                <label for="imagem_turma" style="cursor: pointer;">
                    <img id="preview" src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/avatar.png" alt="Upload de Imagem">
                </label>
                <input type="file" id="imagem_turma" name="imagem_turma" accept="image/*" style="display: none;">
              </div>
            </div>
            <div class="form-bottom">
                <div class="form-group-buton">
                  <?php
                  buttonComponent('secondary', 'Cancelar', false, VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php');
                  buttonComponent('primary', $modoEdicao ? 'Atualizar' : 'Cadastrar', true);
                  ?>
                </div>
              </div>
        </form>
      </div>
    </main>
  </div>
  
  <script>
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