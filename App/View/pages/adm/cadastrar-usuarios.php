<?php 
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/adm/auth.php";
require_once __DIR__ . '/../../../Model/PessoaModel.php';

headerComponent('Cadastro de Pessoa');

$acao = $_GET['acao'] ?? 'cadastrar';
$id = $_GET['id'] ?? null;

$model = new PessoaModel();
$pessoa = null;

if ($acao === 'editar' && $id) {
    $pessoa = $model->buscarPessoaPorId($id);
}

?>

<body class="body-cadastrar-users">
  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php 
      $isAdmin = true;
      require_once __DIR__ . "/../../componentes/nav.php"; 
  ?>

  <main class="conteudo-cadastro">
    <h1 class='h1-usuario'><?= $acao === 'editar' ? 'Editar Pessoa' : 'Cadastro' ?></h1>
    <div class="container-users">
      <div class="form-container-users">
        
        <form class="form-dados" action="../../../Controls/ControllerPessoa.php" method="post" enctype="multipart/form-data">
          <input type="hidden" name="acao" value="<?= htmlspecialchars($acao) ?>">
          <?php if ($acao === 'editar'): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
          <?php endif; ?>

          <div class="form-top">
            <div class="form-group">
              <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($pessoa['nome'] ?? '') ?>" placeholder="Nome Completo" required />
              <input type="email" name="email" id="email" value="<?= htmlspecialchars($pessoa['email'] ?? '') ?>" placeholder="Email" required />
              <input type="text" name="linkedin" id="linkedin" value="<?= htmlspecialchars($pessoa['linkedin'] ?? '') ?>" placeholder="Link do linkedin" />
              <input type="text" name="github" id="github" value="<?= htmlspecialchars($pessoa['github'] ?? '') ?>" placeholder="Link para o GitHub" />
            </div>

            <div class="form-group-polo div-center">
              <select id="tipo-usuario" name="perfil" class="input-text" style="cursor: pointer;">
                <option value="professor" <?= (($pessoa['perfil'] ?? '') === 'professor') ? 'selected' : '' ?>>Professor</option>
                <option value="aluno" <?= (($pessoa['perfil'] ?? '') === 'aluno') ? 'selected' : '' ?>>Aluno</option>
              </select>

              <select id="polo" name="polo" class="input-text" style="cursor: pointer;">
                <option value="">Polo:</option>
                <option value="polo1" <?= (($pessoa['polo'] ?? '') === 'polo1') ? 'selected' : '' ?>>Campo Grande</option>
                <option value="polo2" <?= (($pessoa['polo'] ?? '') === 'polo2') ? 'selected' : '' ?>>Tres Lagoas</option>
                <option value="polo3" <?= (($pessoa['polo'] ?? '') === 'polo3') ? 'selected' : '' ?>>Dourados</option>
                <option value="polo4" <?= (($pessoa['polo'] ?? '') === 'polo4') ? 'selected' : '' ?>>Corumba</option>
                <option value="polo5" <?= (($pessoa['polo'] ?? '') === 'polo5') ? 'selected' : '' ?>>Ponta Pora</option>
              </select>
            </div>

            <div class="form-group-imagem">
              <div class="input-file-cadastro">
                <label class="input-file-wrapper">
                  <img id="preview" src="<?= htmlspecialchars($pessoa['imagem_url'] ?? VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] . 'utilitarios/avatar.png') ?>" alt="Upload" />
                  <input type="file" id="fileInput" name="imagem" accept="image/*" style="display: none;" />
                </label>
              </div>
            </div>
          </div>

          <div class="form-bottom">
            <div class="form-group-buton">
              <button type="button" onclick="window.history.back();" class="secondary-button">Cancelar</button>
              <button type="submit" class="primary-button">
                <?= $acao === 'editar' ? 'Salvar alterações' : 'Cadastrar' ?>
              </button>
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
    // Aqui você pode adicionar lógica para mudar placeholder etc, se quiser
  </script>
</body>
</html>
