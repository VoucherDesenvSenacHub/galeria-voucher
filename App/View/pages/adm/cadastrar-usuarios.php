<?php 
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/input.php";
require_once __DIR__ . "/../../componentes/button.php";

headerComponent('Cadastro de Usuários')
?>

<body class="body-cadastrar-users">
  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php 
      $isAdmin = true; // Para páginas de admin
      require_once __DIR__ . "/../../componentes/nav.php"; 
  ?>

  <main class="conteudo-cadastro">
    <div class="container-users">
      <div class="form-container-users">
        <h1>CADASTRO</h1>
        <form class="form-dados">
          <div class="form-top">
            <div class="form-group">
              <?php 
                inputComponent('text', 'nome', 'Nome Completo');
                inputComponent('text', 'email', 'Email');
                inputComponent('text', 'linkedin', 'Link do linkedin');
                inputComponent('text', 'github', 'Link para o GitHub');
              ?>
            </div>

            <div class="form-group-polo">
              <select id="tipo-usuario" class="input-text" style="cursor: pointer;">
                <option value="professor" selected>Professor</option>
                <option value="aluno">Aluno</option>
              </select>

              <select id="polo" name="polo" class="input-text" style="cursor: pointer;">
                <option value="">Polo:</option>
                <option value="polo1">Campo Grande</option>
                <option value="polo2">Tres Lagoas</option>
                <option value="polo2">Dourados</option>
                <option value="polo2">Corumba</option>
                <option value="polo2">Ponta Pora</option>
              </select>

              <select id="campo-turma" name="turma" class="input-text" style="cursor: pointer;">
                <option value="">Turma:</option>
                <option value="turma1">Turma 144</option>
                <option value="turma2">Turma 145</option>
                <option value="turma3">Turma 146</option>
                <option value="turma4">Turma 147</option>
                <option value="turma5">Turma 148</option>
              </select>
            </div>

            <div class="form-group-imagem">
              <div class="input-file-cadastro">
                <label class="input-file-wrapper">
                  <img id="preview" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/avatar.png" alt="Upload" />
                  <input type="file" id="fileInput" accept="image/*" style="display: none;" />
                </label>
              </div>
            </div>
          </div>
          <div class="form-bottom">
            <div class="form-group-about">
              <textarea id="informacoes-adicionais" class="input-text" name="informacoes-adicionais" rows="15" cols="140" placeholder="Digite algo sobre o docente..."></textarea>
            </div>

            <div class="form-group-buton">
              <?php 
                buttonComponent('secondary', 'Cancelar', false);
                buttonComponent('primary', 'Cadastrar', true);
              ?>
            </div>
          </div>
        </form>
      </div>
    </div>
  </main>

  <script>
    const fileInput = document.getElementById('fileInput');
    const previewImg = document.getElementById('preview');

    fileInput.addEventListener('change', function () {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    const tipoUsuario = document.getElementById('tipo-usuario');
    const textareaSobre = document.getElementById('informacoes-adicionais');

    function atualizarPlaceholder(tipo) {
      if (tipo === 'professor') {
        textareaSobre.placeholder = 'Digite algo sobre o professor...';
      } else {
        textareaSobre.placeholder = 'Digite algo sobre o aluno...';
      }
    }

    window.addEventListener('load', () => {
      atualizarPlaceholder(tipoUsuario.value);
    });

    tipoUsuario.addEventListener('change', () => {
      atualizarPlaceholder(tipoUsuario.value);
    });
  </script>
</body>
</html>
