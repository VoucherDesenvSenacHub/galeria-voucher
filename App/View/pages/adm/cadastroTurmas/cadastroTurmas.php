<?php
require_once __DIR__ . "/../../../../Config/env.php";
require_once __DIR__ . "/../../../componentes/head.php";
headerComponent("Voucher Desenvolvedor - Turma");
require_once __DIR__ . "/../../../componentes/adm/auth.php";

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
        <form id="form-cadastro-turma" method="POST" action="<?= VARIAVEIS['APP_URL'] ?>App/Controls/TurmaController.php?action=salvar" enctype="multipart/form-data" style="width: 100%;">
            <div class="form-top">
              <div class="form-section">
                <h1 class='h1-turma'>CADASTRO DE TURMA</h1>
                
                <input type="text" name="nome" placeholder="Nome da Turma:" class="input-adm-turmas" required>
                
                <textarea name="descricao" placeholder="Descrição da Turma" class="input-adm-turmas" style="height: 100px; border-radius: 15px; padding-top: 15px;"></textarea>

                <label for="data_inicio" style="font-size: 1rem; margin-left: 15px;">Data de Início:</label>
                <input type="date" name="data_inicio" class="input-adm-turmas" required>

                <label for="data_fim" style="font-size: 1rem; margin-left: 15px;">Data de Fim (opcional):</label>
                <input type="date" name="data_fim" class="input-adm-turmas">
                
                <input type="text" name="polo" placeholder="Polo:" class="input-adm-turmas" required>
              </div>

              <div class="profile-pic">
                 <label for="imagem_turma" style="cursor: pointer;">
                    <img id="preview" src="<?= VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/avatar.png" alt="Upload de Imagem">
                </label>
                <input type="file" id="imagem_turma" name="imagem_turma" accept="image/*" style="display: none;">
                <small style="text-align: center; display: block;">Clique na imagem para alterar</small>
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
    // Script para preview da imagem
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