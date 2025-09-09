<?php

$paginaAtiva = 'pessoas';

require_once __DIR__ . "/../../../Controller/cadastrar_pessoa.php";
require_once __DIR__ . "/../../componentes/head.php";
require_once __DIR__ . "/../../componentes/adm/auth.php";
require_once __DIR__ . '/../../../Model/PessoaModel.php';
require_once __DIR__ . '/../../../Model/PoloModel.php';
require_once __DIR__ . "/../../componentes/breadCrumbs.php";

headerComponent('Cadastro de Pessoa');

$acao = $_GET['acao'] ?? 'cadastrar';
$id = $_GET['id'] ?? null;

$model = new PessoaModel();
$pessoa = null;
$perfis = $model->listarPerfisPermitidos();

if ($acao === 'editar' && $id) {
  $pessoa = $model->buscarPessoaComPoloPorId((int)$id);
}

?>

<body class="body-cadastrar-users">
  <?php require_once __DIR__ . "/../../componentes/adm/sidebar.php"; ?>
  <?php
  $isAdmin = true; // Para páginas de admin
  require_once __DIR__ . "/../../componentes/nav.php";
  ?>

  <main class="conteudo-cadastro">
    <?php BreadCrumbs::gerarBreadCrumbs()?>
    <h1 class='h1-usuario'><?= $acao === 'editar' ? 'EDITAR PESSOA' : 'CADASTRO' ?></h1>
    <?php if (!empty($_GET['erro'])): ?>
      <div style="margin: 12px 0; color: #b00020; font-weight: 600;"><?= htmlspecialchars($_GET['erro']) ?></div>
    <?php endif; ?>
    <div class="container-users">
      <div class="form-container-users">

        <form class="form-dados" method="POST" enctype="multipart/form-data" action="/galeria-voucher/App/Controller/ControllerPessoa.php">
          <input type="hidden" name="acao" value="<?= $acao ?>">
          <?php if ($acao === 'editar' && $id): ?>
            <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
          <?php endif; ?>
          <div class="form-top">
            <div class="form-group">
              <?php
              inputComponent('text', 'nome', 'Nome Completo *', $pessoa['nome'] ?? ($_POST['nome'] ?? ''));
              inputComponent('text', 'email', 'Email *', $pessoa['email'] ?? ($_POST['email'] ?? ''));
              inputComponent('text', 'linkedin', 'Link do linkedin', $pessoa['linkedin'] ?? ($_POST['linkedin'] ?? ''));
              inputComponent('text', 'github', 'Link para o GitHub', $pessoa['github'] ?? ($_POST['github'] ?? ''));
              ?>
            </div>
            <div class="form-group-polo div-center">
              <label for="tipo-usuario" style="font-weight: bold;">Perfil *</label>
              <select id="tipo-usuario" name="perfil" class="input-text" style="cursor: pointer;">
                <option value="">-- Selecione --</option>
                <?php foreach ($perfis as $perfil): ?>
                  <option value="<?= htmlspecialchars($perfil) ?>"
                    <?= (($pessoa['perfil'] ?? ($_POST['perfil'] ?? '')) === $perfil) ? 'selected' : '' ?>>
                    <?= ucfirst(htmlspecialchars($perfil)) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="form-group-imagem">
              <label style="font-weight: bold;">Imagem *</label>
              <div class="input-file-cadastro">
                <label class="input-file-wrapper">
                  <img id="preview" src="<?php echo VARIAVEIS['APP_URL'] . VARIAVEIS['DIR_IMG'] ?>utilitarios/avatar.png" alt="Upload" />
                  <input type="file" name="imagem" id="fileInput" accept="image/*" style="display: none;" />
                </label>
              </div>
            </div>
          </div>
          <div class="form-bottom">
            <div class="form-group-buton">
              <?php
              buttonComponent('secondary', 'Cancelar', 'reset', false, null, null, 'back-button');
              buttonComponent('primary', $acao === 'editar' ? 'Atualizar' : 'Cadastrar', true);
              ?>
            </div>
          </form>
      </div>
    </div>
  </main>

  <script>
    const fileInput = document.getElementById('fileInput');
    const previewImg = document.getElementById('preview');

    fileInput.addEventListener('change', function() {
      const file = this.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          previewImg.src = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    });

    const tipoUsuario = document.getElementById('tipo-usuario');
    // Aqui você pode adicionar lógica para mudar placeholder etc, se quiser
  </script>
  <?php if (!empty($mensagem)): ?>
    <script>
      alert("<?= addslashes($mensagem) ?>");
      window.location.href = 'listarUsuarios.php';
    </script>
  <?php endif; ?>

</body>
</html>

