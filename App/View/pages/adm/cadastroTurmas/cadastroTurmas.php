<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Turma");
require_once __DIR__ . "/../../../componentes/adm/auth.php";
require_once __DIR__ . "/../../../../Model/PoloModel.php";

try {
    $poloModel = new PoloModel();
    $polos = $poloModel->buscarTodos();
} catch (Exception $e) {
    $polos = [];
    $_SESSION['erros_turma'] = ["Erro ao carregar a lista de polos."];
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
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
        
        <?php if (isset($_SESSION['sucesso_turma'])): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin: 20px auto; width: 80%; text-align: center;">
                <?= htmlspecialchars($_SESSION['sucesso_turma']) ?>
            </div>
            <?php unset($_SESSION['sucesso_turma']); ?>
            <script>
                setTimeout(function() {
                    window.location.href = "<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_ADM'] . 'listaTurmas.php' ?>";
                }, 4000); // Redireciona após 4 segundos
            </script>
        <?php endif; ?>

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

        <form id="form-cadastro-turma" method="POST" action="<?= VARIAVEIS['APP_URL'] ?>App/Controls/TurmaController.php?action=salvar" enctype="multipart/form-data" style="width: 100%;">
            <div class="form-top">
              <div class="form-section">
                <h1 class='h1-turma'>CADASTRO DE TURMA</h1>
                
                <input type="text" name="nome" placeholder="Nome da Turma:" class="input-adm-turmas" required>

                <textarea name="descricao" placeholder="Descrição:" class="input-adm-turmas"></textarea>

                <label for="polo_id"></label>
                <select name="polo_id" id="polo_id" class="input-adm-turmas" required>
                    <option value="">Selecione um Polo</option>
                    <?php foreach ($polos as $polo): ?>
                        <option value="<?= htmlspecialchars($polo['polo_id']) ?>"><?= htmlspecialchars($polo['nome']) ?></option>
                    <?php endforeach; ?>
                </select>

                <label for="data_inicio" class="input-adm-turmas">Início:</label>
                <input type="date" name="data_inicio" class="input-adm-turmas" required>

                <label for="data_fim" class="input-adm-turmas">Término</label>

                <input type="date" name="data_fim" class="input-adm-turmas">

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
                  buttonComponent('primary', 'Cadastrar', true);
                  ?>
                </div>
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
            reader.onload = function(e) {
                previewImage.src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
  </script>

</body>
</html>